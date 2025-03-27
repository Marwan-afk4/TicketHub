<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{

    use Image;

    public function getModels(){
        $carModels = CarModel::all();
        $data = $carModels->map(function($carModel){
            return [
                'id' => $carModel->id,
                'brand_id' => $carModel->brand_id,
                'brand_name' => $carModel->carbrand->name,
                'name' => $carModel->name,
                'image' => $carModel->image ? asset('storage/' . $carModel->image) : null,
                'status' => $carModel->status
            ];
        });
        return response()->json($data);
    }

    public function addCarModel(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:car_models,name'],
            'brand_id' => ['required','exists:car_brands,id'],
            'image' => ['nullable', 'string'],
            'status' => ['required']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carModel = CarModel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'status' => $request->status,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_model') : null,
        ]);

        return response()->json([
            'message' => 'Car Model Created Successfully',
        ]);
    }

    public function updateCarModel(Request $request, $id){
        $validation = Validator::make($request->all(),[
            'name' => ['sometimes', 'string', 'unique:car_models,name,'.$id],
            'brand_id' => ['sometimes','exists:car_brands,id'],
            'image' => ['sometimes', 'string'],
            'status' => ['sometimes']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carModel = CarModel::find($id);
        if($carModel){
            $carModel->update([
                'name' => $request->name ?? $carModel->name,
                'brand_id' => $request->brand_id ?? $carModel->brand_id,
                'status' => $request->status ?? $carModel->status,
                'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_model') : $carModel->image,
            ]);
            return response()->json(['message'=>'Car Model Updated Successfully'],200);
        }
    }

    public function deleteCarModel($id){
        $carModel = CarModel::find($id);
        if($carModel){
            $carModel->delete();
            return response()->json(['message'=>'Car Model Deleted Successfully'],200);
        }
    }
}
