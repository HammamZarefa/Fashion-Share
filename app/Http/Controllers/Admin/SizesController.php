<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    public function index()
    {
        $page_title = 'Size';
        $empty_message = 'No Result Found';
        $categories = Category::all();
        $sizes = Size::with('category')->latest()->get();
        return view('admin.sizes.index', compact('page_title', 'sizes','categories', 'empty_message'));
    }

    public function store()
    {

        \request()->validate([
            'name' => 'required|string|max:70',
            'category_id'=>'required|exists:categories,id',
        ]);
        $request = \request();
        $Size = new Size();
        $Size->name = $request->name;
        $Size->category_id = $request->category_id;     
        $Size->save();

            $notify[] = ['success', 'Size added!'];
            return back()->withNotify($notify);


    }
    public function update($id,Request $request)
    {
        \request()->validate([
            'name' => 'required|string|max:70|unique:sizes,name,' . $id,
            'category_id'=>'nullable|exists:categories,id',

        ]);
        $Size = Size::findOrFail($id);
        $Size->name = \request()->name;
        $Size->category_id = request()->category_id;
        $Size->save();

        $notify[] = ['success', 'Size updated!'];
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
        $page_title = 'Sizes';
        $empty_message = 'No Result Found';
        $categories = Category::all();
        
        $sizes = Size::where('category_id',$id)->with('category')->latest()->get();
        return view('admin.sizes.index', compact('page_title', 'sizes','categories', 'empty_message'));
      }
}
