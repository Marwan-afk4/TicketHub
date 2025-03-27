<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarBrandController extends Controller
{

    use Image;

    public function getBrands(){
        $carBrands = CarBrand::all();

        $data =$carBrands->map(function($carBrand){
            return [
                'id' => $carBrand->id,
                'category_id' => $carBrand->category_id,
                'category_name' => $carBrand->carcategory->name,
                'name' => $carBrand->name,
                'image' => $carBrand->image ? asset('storage/' . $carBrand->image) : null,
                'status' => $carBrand->status
            ];
        });
        return response()->json($data);
    }

    public function addBrands(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:car_brands,name'],
            'category_id' => ['required','exists:car_categories,id'],
            'image' => ['nullable', 'string'],
            'status' => ['required']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carBrand = CarBrand::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_brand') : null,
        ]);

        return response()->json(['message'=>'Car Brand Created Successfully'],200);
    }

    public function updateBrands(Request $request, $id){
        $validation = Validator::make($request->all(),[
            'name' => ['sometimes', 'string', 'unique:car_brands,name,'.$id],
            'category_id' => ['sometimes','exists:car_categories,id'],
            'image' => ['sometimes', 'string'],
            'status' => ['sometimes']
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $carBrand = CarBrand::find($id);
        if($carBrand){
            $carBrand->update([
                'name' => $request->name ?? $carBrand->name,
                'category_id' => $request->category_id ?? $carBrand->category_id,
                'status' => $request->status ?? $carBrand->status,
                'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car_brand') : $carBrand->image,
            ]);
            return response()->json(['message'=>'Car Brand Updated Successfully'],200);
        }
    }

    public function deleteBrands($id){
        $carBrand = CarBrand::find($id);
        if($carBrand){
            $carBrand->delete();
            return response()->json(['message'=>'Car Brand Deleted Successfully'],200);
        }
    }
}
