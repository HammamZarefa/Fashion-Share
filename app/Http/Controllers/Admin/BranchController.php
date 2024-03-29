<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\InvoicesProdect;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $page_title = 'Branch';
        $empty_message = 'No Result Found';
        $branch = Branch::with('Admin')->get();
        return view('admin.branch.index', compact('branch', 'page_title', 'empty_message'));
    }

    public function edit($id)
    {
        $page_title = 'Branch';
        $empty_message = 'No Result Found';
        $item = Branch::with('Admin')->find($id);
        return view('admin.branch.edit', compact('item', 'page_title', 'empty_message'));
    }

    public function show($id)
    {
        $page_title = 'Branch';
        $empty_message = 'No Result Found';
        $item = Branch::with('Admin')->find($id);
        return view('admin.branch.show', compact('item', 'page_title', 'empty_message'));
    }

    public function dashboard($id)
    {
        $page_title = 'Invoices';
        $branchProduct = Auth::guard('admin')->user()->branch_id;
        $branchs = Branch::where(function ($query) use ($branchProduct) {
            if (isset($branchProduct)) {
                $query->where('id', $branchProduct);
            }
        })->select('id', 'name')->first();
//        dd($branchs);
//        $sections = $branchs->sections ? $branchs->sections : null;
//        $categories = $branchs->categories;
//
//        $invoices = InvoicesProdect::whereHas('products', function ($query) use ($branchProduct, $id) {
//            if (isset($branchProduct)) {
//                $query->where('branch_id', $branchProduct);
//            } elseif (isset($id)) {
//                $query->where('branch_id', $id);
//            }
//        })->latest()->paginate(getPaginate());

        $branch_id = $id;
        $adminBransh = Admin::where('is_from_admin', 1)->first();

        if ($adminBransh != null) {
            $adminBransh->is_from_admin = true;
            $adminBransh->super_admin_id = Auth::guard('admin')->user()->id;
            $adminBransh->branch_id = $branch_id;
            $adminBransh->save();
            Auth::guard('admin')->loginUsingId($adminBransh->id);
            return redirect()->route('admin.invoices');
        } else {
            return redirect()->back()->with('error', __('No Admin For This Branch'));
        }


        return view('admin.Invoices.index', compact('page_title', 'id', 'branchs', 'invoices', 'sections', 'categories'));
    }

    public function loginAccount(Request $request, $id)
    {
        Auth::guard('web')->loginUsingId($id);
        return redirect()->route('user.home');
    }

    public function store(Request $request)
    {
        \request()->validate([
            'name' => 'required|string',
            'code' => 'required|string|size:2|regex:/^[A-Z]+$/',
            'address' => 'required|string',

            'location' => 'nullable|string',

            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',

            'working_hours' => 'required|string',
            'phone' => 'nullable|string',
            'mobile' => 'required|string',
            'whatsapp' => 'required|string',
        ]);
        $social['facebook'] = \request()->facebook;
        $social['instagram'] = \request()->instagram;
        $social['twitter'] = \request()->twitter;

        $branch = Branch::create([
            'name' => \request()->name,
            'code' => \request()->code,
            'address' => \request()->address,
            'working_hours' => \request()->working_hours,
            'phone' => \request()->phone,
            'mobile' => \request()->mobile,
            'whatsapp' => \request()->whatsapp,
            'latitude' => \request()->latitude,
            'longitude' => \request()->longitude,
            'location' => \request()->latitude . ',' . \request()->longitude,
            'social' => json_encode($social),

        ]);

        $notify[] = ['success', 'Branch created!'];
        return back()->withNotify($notify);
    }

    public function update($id, Request $request)
    {
        \request()->validate([
            'name' => 'required|string',
            'code' => 'required|string|size:2|regex:/^[A-Z]+$/',
            'address' => 'required|string',

            'location' => 'nullable|string',

            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',

            'working_hours' => 'required|string',
            'phone' => 'nullable|string',
            'mobile' => 'required|string',
            'whatsapp' => 'required|string',
        ]);

        $social['facebook'] = \request()->facebook;
        $social['instagram'] = \request()->instagram;
        $social['twitter'] = \request()->twitter;

        $branch = Branch::findOrFail($id);
        $branch->name = \request()->name;
        $branch->code = \request()->code;
        $branch->address = \request()->address;
        $branch->location = \request()->location;
        $branch->working_hours = \request()->working_hours;
        $branch->phone = \request()->phone;
        $branch->mobile = \request()->mobile;
        $branch->whatsapp = \request()->whatsapp;
        $branch->social = json_encode($social);
        $branch->latitude = \request()->latitude;
        $branch->longitude = \request()->longitude;
        $branch->location = \request()->latitude . ',' . \request()->longitude;

        $branch->save();
        $notify[] = ['success', 'Branch updated!'];
        return redirect()->route('admin.branch')->withNotify($notify);

    }

    public function delete($id)
    {
        $item = Branch::findOrFail($id);
        $item->delete();
        $notify[] = ['success', 'branch deleted!'];
        return back()->withNotify($notify);
    }

    public function statistics()
    {
        $page_title = 'Statistics';
        $branch = Auth::guard('admin')->user()->branch;
        $branchId = $branch->id;
        $sections = $branch->sections()->leftJoin('products', function ($join) use ($branchId) {
            $join->on('sections.id', '=', 'products.section_id')
                ->where('products.branch_id', '=', $branchId);
        })
            ->groupBy('sections.id')
            ->select('sections.*', \DB::raw('COUNT(products.id) AS product_count'))
            ->get();
        $bestSellers = Product::withCount('invoicesProducts')
            ->where('branch_id', $branchId)
            ->orderBy('invoices_products_count', 'desc')
            ->get();

        $bestSellerCategory = [];
        foreach ($bestSellers as $bestSeller) {
            $category = Category::find($bestSeller->category_id);
            if (isset($category->id) && !isset($bestSellerCategory[$category->id])) {
                $bestSellerCategory[$category->id] = [
                    'category_name' => $category->name,
                    'invoicesProducts_count' => 0,
                ];
            }
            if (isset($category->id))
                $bestSellerCategory[$category->id]['invoicesProducts_count'] += $bestSeller->invoices_products_count;
        }
        return view('admin.branch.statistics', compact('page_title', 'sections', 'bestSellerCategory'));
    }
}
