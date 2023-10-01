<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    public function index($model)
    {
        $model = Str::ucfirst($model);
        $modelClass = "App\\Models\\$model";
        $page_title = $model;
        $empty_message = 'No Result Found';
        $items = $modelClass::latest()->get();
        return view('admin.models.index', compact('page_title', 'items', 'empty_message', 'model'));
    }

    public function store($model)
    {
        $model = Str::ucfirst($model);
        $modelClass = "App\\Models\\$model";
        \request()->validate([
            'name' => 'required|string|max:70',
        ]);
        $request = \request();
        $object = new $modelClass;
        $object->name = $request->name;
        $object->save();
        $notify[] = ['success', $model . ' added!'];
        return back()->withNotify($notify);


    }

    public function update($model, $id, Request $request)
    {
        $model = Str::ucfirst($model);
        $modelClass = "App\\Models\\$model";
        \request()->validate([
            'name' => 'required|string|max:70'
        ]);
        $item = $modelClass::findOrFail($id);
        $item->name = \request()->name;
        $item->save();
        $notify[] = ['success', $model . ' updated!'];
        return back()->withNotify($notify);
    }

    public function delete($model, $id)
    {
        $model = Str::ucfirst($model);
        $modelClass = "App\\Models\\$model";
        $item = $modelClass::findOrFail($id);
        $item->delete();
        $notify[] = ['success', $model . ' deleted!'];
        return back()->withNotify($notify);
    }
}
