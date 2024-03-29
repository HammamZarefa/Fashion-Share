<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use mysql_xdevapi\Collection;

class CategoryController extends Controller
{
    public function index()
    {
        $auth =Auth::guard('admin')->user();
        $page_title = 'Categories';
        $empty_message = 'No Result Found';

        if ($auth->branch != null){
            $categories = [];
            $sections = $auth->branch->sections;
            foreach ($sections as $section){
                foreach ($section->category as $category){
                    array_push($categories, $category);
                }

            }
            $categories = collect($categories);
        }else{
            $sections = Section::all();
            $categories = Category::with('section')->latest()->get();
        }
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

    public function add($id)
    {
        $cat = Category::findOrFail($id);
        $branch = Auth::guard('admin')->user()->branch;
        if ($branch->categories()->where('branchable_id', $cat->id)->exists()) {
            $branch->categories()->detach($cat);
        } else {
            $branch->categories()->attach($cat);
        }

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    public function search($id){
        $auth =Auth::guard('admin')->user();
        $page_title = 'Categories';
        $empty_message = 'No Result Found';
        if ($auth->branch != null){
            $categories = [];
            $sections = $auth->branch->sections;
        }else{
            $sections = Section::all();
        }
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
