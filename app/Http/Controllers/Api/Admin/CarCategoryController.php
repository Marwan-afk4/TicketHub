<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarCategoryController extends Controller
{
    use Image;

    public function getCategories(){
        $carCategories = CarCategory::all();

        $data =$carCategories->map(function($carCategory){
            return [
                'id' => $carCategory->id,
                'name' => $carCategory->name,
                'image' => $carCategory->image ? asset('storage/' . $carCategory->image) : null,
                'status' => $carCategory->status
            ];
        });
        return response()->json($data);
    }

    public function addCarCategories(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:car_categories,name'],
            'image' => ['nullable', 'string'],
            'status' => ['required']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carCategory = CarCategory::create([
            'name' => $request->name,
            'status' => $request->status,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_category') : null,
        ]);

        return response()->json(['message'=>'Car Category Created Successfully'],200);
    }

    public function updateCarCategories(Request $request, $id){
        $validation = Validator::make($request->all(),[
            'name' => ['sometimes', 'string', 'unique:car_categories,name,'.$id],
            'image' => ['sometimes', 'string'],
            'status' => ['sometimes']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carCategory = CarCategory::find($id);
        if($carCategory){
            $carCategory->update([
                'name' => $request->name ?? $carCategory->name,
                'status' => $request->status ?? $carCategory->status,
                'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_category') : $carCategory->image,
            ]);
            return response()->json(['message'=>'Car Category Updated Successfully'],200);
        }
    }

    public function deleteCarCategories($id){
        $carCategory = CarCategory::find($id);
        if($carCategory){
            $carCategory->delete();
            return response()->json(['message'=>'Car Category Deleted Successfully'],200);
        }
    }
}
