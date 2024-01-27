<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page_title = 'Suppliers';
        $empty_message = 'No Result Found';
        $suppliers = Supplier::with(['user','products'])->latest()->get();
        $users = User::all();
        return view('admin.suppliers.index', compact('page_title', 'suppliers', 'empty_message','users'));
    }
    public function show($id)
    {

        $supplier = Supplier::with(['user','products'])->where('id',$id)->firstOrFail();
        $page_title = 'Supplier : '.$supplier->name;
        $empty_message = 'No Result Found';
        return view('admin.suppliers.show', compact('page_title', 'supplier', 'empty_message'));
    }

    public function store()
    {
        \request()->validate([
            'name' => 'required|string|max:70',
            'email'=>'required|string|max:70',
            'mobile'=>'required|string|max:70',
        ]);
        $request = \request();
        $supplier= new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->mobile = $request->mobile;
        if ($request->user_id != "-1"){
            $supplier->user_id = $request->user_id;
        }else{
            $supplier->user_id = null;
        }
        $supplier->save();

        $notify[] = ['success', 'Supplier added!'];
        return back()->withNotify($notify);
    }
    public function update($id,Request $request)
    {
        \request()->validate([
            'name' => 'required|string|max:70',
            'email'=>'required|string|max:70',
            'mobile'=>'required|string|max:70',
        ]);
        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->mobile = $request->mobile;
        if ($request->user_id != "-1"){
            $supplier->user_id = $request->user_id;
        }else{
            $supplier->user_id = null;
        }
        $supplier->save();

        $notify[] = ['success', 'Supplier updated!'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $cat = Category::findOrFail($id);
        $cat->status = ($cat->status ? 0 : 1);
        $cat->save();

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    public function search($id){
        $page_title = 'Styles';
        $empty_message = 'No Result Found';
        $categories = Category::all();
        $sections = Section::all();

        $styles = Style::where('category_id',$id)->with('category')->latest()->get();
        return view('admin.styles.index', compact('page_title', 'id','styles','categories','sections', 'empty_message'));
    }

    public function add($id)
    {
        $style = Style::findOrFail($id);
        $branch = Auth::guard('admin')->user()->branch;
        if ($branch->styles()->where('branchable_id', $style->id)->exists()) {
            $branch->styles()->detach($style);
        } else {
            $branch->styles()->attach($style);
        }

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    public function delete($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        $notify[] = ['success', 'Supplier Deleted!'];
        return back()->withNotify($notify);
    }
}
