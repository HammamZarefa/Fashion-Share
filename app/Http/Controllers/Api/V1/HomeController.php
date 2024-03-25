<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomFieldResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    function getDataByModelName($modelName,$branchId = null)
    {
        try {
            $validatedData = validator(['model_name' => $modelName], [
                'model_name' => 'required|
            in:size,color,section,condition,material,branch,category,banner,season,style,supplier'
            ])->validate();
            if ($branchId != null){
                $branch = Branch::find($branchId);
                $models = $modelName.'s';
                $data = $branch->$models;
            }else{
                $modelName = ucfirst($modelName);
                $data = app("App\\Models\\{$modelName}")->all();
            }

            return CustomFieldResource::collection($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    function getDataByModels(Request $request,$branchId = null)
    {
        try {
            $validatedData = validator(['models' => $request->models], [
                'models' => 'required|array',
                'models.*' => 'in:size,color,section,condition,material,branch,category,banner,season,style,supplier'
            ])->validate();
            $data = [];
            if ($branchId != null) {
                $branch = Branch::find($branchId);
                if (empty($branch)) {
                    return response()->json(['message' => 'Branch does not exist or has been deleted'], 404);
                }
                foreach ($request->models as $model) {
                    if ($model == 'category'){
                        $models = 'categories';
                        $datamodel = $branch->$models;
                        $modelName = ucfirst($model);
                        $data[$modelName] = CustomFieldResource::collection($datamodel);
                    }elseif ($model == 'branch'){

                    }elseif ($model == 'supplier'){
                        $modelName = ucfirst($model);
                        $datamodel = app("App\\Models\\{$modelName}")->all();
                        $data[$modelName] = CustomFieldResource::collection($datamodel);
                    }elseif ($model == 'banner'){
                        $modelName = ucfirst($model);
                        $datamodel = app("App\\Models\\{$modelName}")->all();
                        $data[$modelName] = CustomFieldResource::collection($datamodel);
                    }else{
                        $models = $model.'s';
                        $datamodel = $branch->$models;
                        $modelName = ucfirst($model);
                        $data[$modelName] = CustomFieldResource::collection($datamodel);
                    }
                }
            }else{
                foreach ($request->models as $model) {
                    $modelName = ucfirst($model);
                    $datamodel = app("App\\Models\\{$modelName}")->all();
                    $data[$modelName] = CustomFieldResource::collection($datamodel);
                }
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
