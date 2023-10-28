<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Image;

class CategoryController extends Controller
{
    public function index()
    {
        $page_title = 'Categories';
        $empty_message = 'No Result Found';
        $sections = Section::all();
        $categories = Category::with('section')->latest()->get();
        return view('admin.categories.index', compact('page_title', 'categories','sections', 'empty_message'));
    }

    public function store()
    {

        \request()->validate([
            'name' => 'required|string|max:70',
            'section_id'=>'required|exists:sections,id',
            'image' => '',
        ]);
        $request = \request();
        $category = new Category();
        $category->name = $request->name;
        $category->section_id = $request->section_id;


        $image = $request->file('image');
            $path = imagePath()['category']['path'];
            $size = imagePath()['category']['size'];
            $filename = $request->image;
            if ($request->hasFile('image')) {
                try {
                    $filename = uploadImage($image, $path, $size, $filename);
                } catch (\Exception $exp) {
                    $notify[] = ['errors', 'Image could not be uploaded.'];
                    return back()->withNotify($notify);
                }
                $category->image=$filename;
        }
            $category->save();

            $notify[] = ['success', 'Category added!'];
            return back()->withNotify($notify);


    }
    public function update($id,Request $request)
    {
        \request()->validate([
            'name' => 'required|string|max:70|unique:categories,name,' . $id,
            'section_id'=>'nullable|exists:sections,id',

        ]);
        $category = Category::findOrFail($id);
        $category->name = \request()->name;
        $category->section_id = request()->section_id;
        
        $image = $request->file('image');
        $path = 'assets/images/category/';
        $size = imagePath()['category']['size'];
        $oldImage = $category->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $oldImage);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $category->image=$filename;
        }
        $category->save();

        $notify[] = ['success', 'Category updated!'];
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
        $page_title = 'Categories';
        $empty_message = 'No Result Found';
        $sections = Section::all();
        $categories = Category::with('section')->where('section_id',$id)->latest()->get();
        
        return view('admin.categories.index', compact('page_title','id', 'categories','sections', 'empty_message'));
      }

      public function delete($id){
        
        $categories = Category::findOrFail($id);
        if($categories->images){
            $path = imagePath()['category']['path'];
            removeFile($path . '/' . $categories);
        }
        $categories->delete();
        $notify[] = ['success', 'Category Deletedd!'];
        return back()->withNotify($notify);
      }
}
