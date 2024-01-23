<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Section;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Style';
        $empty_message = 'No Result Found';
        $categories = Category::all();
        $sections = Section::all();
        $styles = Style::with(['category','section'])->latest()->get();
        return view('admin.styles.index', compact('page_title', 'styles','categories','sections', 'empty_message'));
    }

    public function store()
    {
        \request()->validate([
            'name' => 'required|string|max:70',
            'category_id'=>'required|exists:categories,id',
            'section_id'=>'required|exists:sections,id',
        ]);
        $request = \request();
        $style= new Style();
        $style->name = $request->name;
        $style->category_id = $request->category_id;
        $style->section_id = $request->section_id;
        $style->save();

        $notify[] = ['success', 'Size added!'];
        return back()->withNotify($notify);
    }
    public function update($id,Request $request)
    {
        \request()->validate([
            'name' => 'required|string|max:70|unique:sizes,name,' . $id,
            'category_id'=>'required|exists:categories,id',
            'section_id'=>'required|exists:sections,id',

        ]);
        $style = Style::findOrFail($id);
        $style->name = $request->name;
        $style->category_id = $request->category_id;
        $style->section_id = $request->section_id;
        $style->save();

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
        $page_title = 'Styles';
        $empty_message = 'No Result Found';
        $categories = Category::all();
        $sections = Section::all();

        $styles = Style::where('category_id',$id)->with('category')->latest()->get();
        return view('admin.styles.index', compact('page_title', 'id','styles','categories','sections', 'empty_message'));
    }

    public function delete($id){
        $style = Style::findOrFail($id);
        $style->delete();
        $notify[] = ['success', 'Color Deleted!'];
        return back()->withNotify($notify);
    }
}
