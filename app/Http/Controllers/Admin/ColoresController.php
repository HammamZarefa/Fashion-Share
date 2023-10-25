<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Colors';
        $empty_message = 'No Result Found';
        $colors = Color::latest()->paginate(getPaginate());
        return view('admin.color.index', compact('page_title', 'colors', 'empty_message'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string','Hexcolor'=>'required|string']);
        $color = new Color();
        $color->name= $request->name;
        $color->Hexcolor = $request->Hexcolor;
        $color->save();
        
        $notify[] = ['success', 'Color added!'];
        return back()->withNotify($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['name'=>'nullable|string','Hexcolor'=>'nullable|string']);
        $color = Color::find($id);
        $color->name= $request->name;
        $color->Hexcolor = $request->Hexcolor;
        $color->save();
        
        $notify[] = ['success', 'Color Updated!'];
        return back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Color::find($id)->delete();
        $notify[] = ['success', 'Color Deleted!'];
        return back()->withNotify($notify);
    }
}
