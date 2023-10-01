<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Banners';
        $empty_message = 'No Result Found';
        $banner = Banner::all();
        return view ('admin.banner.index',compact('banner','page_title','empty_message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Banner';
        return view ('admin.banner.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banner();
        $banner->name  = $request->name;
        $banner->description   = $request->description;
        $banner->button_label   = $request->button_label;
        $image = $request->file('image');
        $path = imagePath()['banner']['path'];
        $size = imagePath()['banner']['size'];
        $filename = $request->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $filename);
//                    dd($filename);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $banner->image=$filename;
        }
        if ($banner->save()) {
            return redirect()->route('admin.banner')->with('success', 'Data added successfully');
           } else {
            return redirect()->route('admin.banner.create')->with('error', 'Data failed to add');

           }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Categories';
        $banner = Banner::findOrFail($id);
        return view ('admin.banner.edit', compact('banner','page_title'));
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
        $banner = Banner::findOrFail($id);
        $banner->name  = $request->name;
        $banner->description   = $request->description;
        $banner->button_label   = $request->button_label;
        $image = $request->file('image');
        $path = 'assets/images/banner/';
        $size = imagePath()['banner']['size'];
        $filename = $request->image;
        if ($request->hasFile('cover')) {
            try {
                $filename = uploadImage($image, $path, $size, $filename);
//                    dd($filename);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        $banner->image = $filename;
    }
    // dd($banner);
        if ($banner->update()) {
            return redirect()->route('admin.banner')->with('success', 'Data updated successfully');
           } else {
            return redirect()->route('admin.banner.edit')->with('error', 'Data failed to update');

           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->delete()) {
            if($banner->image && file_exists(storage_path('app/public/' . $banner->image))){
                \Storage::delete('public/'. $banner->cover);
            }
        }

        return redirect()->route('admin.banner')->with('success', 'Data deleted successfully');
    }
    public function status($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = ($banner->status ? 0 : 1);
        $banner->save();

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }
}
