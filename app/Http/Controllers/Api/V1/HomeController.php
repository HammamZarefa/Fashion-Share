<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomFieldResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    function getDataByModelName($modelName)
    {
        try {
            $validatedData = validator(['model_name' => $modelName], [
                'model_name' => 'required|
            in:size,color,section,condition,material,branch,category,banner'
            ])->validate();
            $modelName = ucfirst($modelName);
            $data = app("App\\Models\\{$modelName}")->all();
            return CustomFieldResource::collection($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    function getDataByModels(Request $request)
    {
        try {
            $validatedData = validator(['models' => $request->models], [
                'models' => 'required|array',
                'models.*' => 'in:size,color,section,condition,material,branch,category,banner'
            ])->validate();
            $data = [];
            foreach ($request->models as $model) {
                $modelName = ucfirst($model);
                $datamodel = app("App\\Models\\{$modelName}")->all();
                $data[$modelName] = CustomFieldResource::collection($datamodel);
            }
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function getCategoryBySection(Request $request){
        $request->validate([ 'section_id'=>'required|exists:sections,id']);
        $category= Category::where('section_id',$request['section_id'])->get();
        return response()->json($category);
    }

    public function getSizeByCategory(Request $request){
        $request->validate([ 'category_id'=>'required|exists:categories,id']);
        $size= Size::where('category_id',$request['category_id'])->get();
        return response()->json($size);
    }
}
