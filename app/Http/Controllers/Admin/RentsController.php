<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\InvoicesProdect;
use App\Models\Product;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class RentsController extends Controller
{
    public function __invoke($id=null)
    {
        $page_title = 'Rents';
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $branch = Branch::where(function($query) use($branch_id){
            if(isset($branch_id)){
                $query->where('id',$branch_id); }
        })->select('id','name')->first();
        $sections = $branch->sections;
        $categories = $branch->categories;

        $invoices = InvoicesProdect::where('is_rent',true)->whereHas('products',function($query)use($branch_id,$id){
            if(isset($branch_id)){
                $query->where('branch_id',$branch_id);
            }
            elseif(isset($id)){
                $query->where('branch_id',$id);
            }
        })->latest()->paginate(getPaginate());

        $invoicesStatistics = InvoicesProdect::where('is_rent',true)->whereHas('products',function($query)use($branch_id,$id){
            if(isset($branch_id)){
                $query->where('branch_id',$branch_id);
            }
            elseif(isset($id)){
                $query->where('branch_id',$id);
            }
        })
            ->selectRaw('SUM(price) as total_price, SUM(discount) as total_discount, SUM(profit) as total_profit')
            ->latest()->paginate(getPaginate());



        return view('admin.rent.index',compact('page_title','id','branch','invoices','sections','categories','invoicesStatistics'));
    }

    public function search(Request $request,$id = null)
    {
        $page_title = 'Invoices';
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $branch = Branch::where(function ($query) use ($branch_id) {
            if (isset($branch_id)) {
                $query->where('id', $branch_id);
            }
        })->select('id', 'name')->first();


        $sections = $branch->sections;
        $categories = $branch->categories;

        $invoices = InvoicesProdect::where('is_rent', true)
            ->whereHas('products', function ($query) use ($branch_id, $id, $request) {
                if (isset($branch_id)) {
                    $query->where('branch_id', $branch_id)
                        ->when($request->product_code, function ($query) use ($request) {
                            $query->where(function ($subquery) use ($request) {
                                $subquery->where('name', 'LIKE', '%' . $request->product_code . '%')
                                    ->orWhere('sku', 'LIKE', '%' . $request->product_code . '%');
                            });
                        })
                        ->when($request->section, function ($query) use ($request) {
                            if ($request->section != '-1') {
                                $query->where('section_id', $request->section);
                            }
                        })
                        ->when($request->category, function ($query) use ($request) {
                            if ($request->category != '-1') {
                                $query->whereHas('category', function ($subquery) use ($request) {
                                    $subquery->where('id', $request->category);
                                });
                            }
                        });
                } elseif (isset($id)) {
                    $query->where('branch_id', $id);
                }
            })
            ->when($request->date, function ($query) use ($request) {
                $query->where('date_of_process', $request->date);
            })
            ->when($request->days, function ($query) use ($request) {
                if (!isset($request->date)) {
                    if ($request->days == '1') {
                        $query->whereDate('date_of_process', Carbon::today());
                    } elseif ($request->days == '2') {
                        $query->whereBetween('date_of_process', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    } elseif ($request->days == '3') {
                        $query->whereMonth('date_of_process', Carbon::now()->month);
                    } elseif ($request->days == '4') {
                        $query->whereYear('date_of_process', Carbon::now()->year);
                    }  else {}
                }
            })
            ->with('products') // Include the related products
            ->latest()
            ->paginate(getPaginate());

        $invoicesStatistics = InvoicesProdect::where('is_rent', true)
            ->whereHas('products', function ($query) use ($branch_id, $id, $request) {
                if (isset($branch_id)) {
                    $query->where('branch_id', $branch_id)
                        ->when($request->product_code, function ($query) use ($request) {
                            $query->where(function ($subquery) use ($request) {
                                $subquery->where('name', 'LIKE', '%' . $request->product_code . '%')
                                    ->orWhere('sku', 'LIKE', '%' . $request->product_code . '%');
                            });
                        })
                        ->when($request->section, function ($query) use ($request) {
                            if ($request->section != '-1') {
                                $query->where('section_id', $request->section);
                            }
                        })
                        ->when($request->category, function ($query) use ($request) {
                            if ($request->category != '-1') {
                                $query->whereHas('category', function ($subquery) use ($request) {
                                    $subquery->where('id', $request->category);
                                });
                            }
                        });
                } elseif (isset($id)) {
                    $query->where('branch_id', $id);
                }
            })
            ->when($request->date, function ($query) use ($request) {
                $query->where('date_of_process', $request->date);
            })
            ->when($request->days, function ($query) use ($request) {
                if (!isset($request->date)) {
                    if ($request->days == '1') {
                        $query->whereDate('date_of_process', Carbon::today());
                    } elseif ($request->days == '2') {
                        $query->whereBetween('date_of_process', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    } elseif ($request->days == '3') {
                        $query->whereMonth('date_of_process', Carbon::now()->month);
                    } elseif ($request->days == '4') {
                        $query->whereYear('date_of_process', Carbon::now()->year);
                    }  else {}
                }
            })
            ->selectRaw('SUM(price) as total_price, SUM(discount) as total_discount, SUM(profit) as total_profit')
            ->latest()
            ->paginate(getPaginate());

        return view('admin.rent.index', compact('page_title', 'id', 'branch', 'invoices','invoicesStatistics','sections','categories'));
    }

    public function create()
    {
        $page_title = 'Rent Create';
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $products = Product::where('branch_id',$branch_id)
            ->where('status', 'available')
            ->whereHas('section',function($query){
                    $query->where('is_rent',true);
            })
            ->get();
        $lastInvoice = InvoicesProdect::get()->last();
        return view('admin.rent.create',compact('page_title','products','lastInvoice'));
    }

    public function store(Request $request)
    {
        $branchAdmin = Auth::guard('admin')->user();
        $invoice = new InvoicesProdect();
        $invoice->status = 'created';
        $invoice->is_rent = true;
        $invoice->discount = null;
        $invoice->date_of_process = Carbon::now();
        $invoice->price = (float)$request->total_price;

        $invoice->user_id = null;
        $invoice->date_of_return = null;
        $invoice->username = $request->client_name;
        $invoice->mobile = $request->mobile;
        foreach ($request->products as $product){
            $details[] = [
                'product_id' => $product,
                'return_date' =>$request['return_date_'.$product]
            ];
        }
        $invoice->details = json_encode($details,true);
        $invoice->save();
        foreach ($request->products as $product){
            $invoice->products()->attach($product);
        }

        return redirect()->route('admin.rents')->with('success','Invoice Added Successfully');

        dd($request);
    }
}
