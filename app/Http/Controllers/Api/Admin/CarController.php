<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

    use Image;

    public function getCar(){
        $cars = Car::all();
        $data =$cars->map(function($car){
            return [
                'id' => $car->id,
                'category_id' => $car->category_id,
                'category_name' => $car->category->name,
                'brand_id' => $car->brand_id,
                'brand_name' => $car->brand->name,
                'model_id' => $car->model_id,
                'model_name' => $car->model->name,
                'agent_id' => $car->agent_id,
                'agent_name' => $car->agent->name,
                'car_number' => $car->car_number,
                'car_color' => $car->car_color,
                'car_year' => $car->car_year,
                'status' => $car->status,
                'image' => $car->image ? asset('storage/' . $car->image) : null
            ];
        });
        return response()->json($data);
    }

    public function addCar(Request $request){
        $validation = Validator::make($request->all(),[
            'category_id' => ['required','exists:car_categories,id'],
            'brand_id' => ['required','exists:car_brands,id'],
            'model_id' => ['required','exists:car_models,id'],
            'agent_id' => ['required','exists:users,id'],
            'car_number' => ['required'],
            'car_color' => ['required'],
            'car_year' => ['required'],
            'status' => ['required'],
            'image' => ['nullable', 'string'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $car = Car::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'model_id' => $request->model_id,
            'agent_id' => $request->agent_id,
            'car_number' => $request->car_number,
            'car_color' => $request->car_color,
            'car_year' => $request->car_year,
            'status' => $request->status,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car') : null,
        ]);

        return response()->json(['message'=>'Car Created Successfully'],200);
    }

    public function updateCar(Request $request, $id){
        $validation = Validator::make($request->all(),[
            'category_id' => ['sometimes','exists:car_categories,id'],
            'brand_id' => ['sometimes','exists:car_brands,id'],
            'model_id' => ['sometimes','exists:car_models,id'],
            'agent_id' => ['sometimes','exists:users,id'],
            'car_number' => ['sometimes'],
            'car_color' => ['sometimes'],
            'car_year' => ['sometimes'],
            'status' => ['sometimes'],
            'image' => ['sometimes', 'string'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $car = Car::find($id);
        if($car){
            $car->update([
                'category_id' => $request->category_id ?? $car->category_id,
                'brand_id' => $request->brand_id ?? $car->brand_id,
                'model_id' => $request->model_id ?? $car->model_id,
                'agent_id' => $request->agent_id ?? $car->agent_id,
                'car_number' => $request->car_number ?? $car->car_number,
                'car_color' => $request->car_color ?? $car->car_color,
                'car_year' => $request->car_year ?? $car->car_year,
                'status' => $request->status ?? $car->status,
                'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/car') : $car->image,
            ]);
            return response()->json(['message'=>'Car Updated Successfully'],200);
        }
    }

    public function deleteCar($id){
        $car = Car::find($id);
        if($car){
            $car->delete();
            return response()->json(['message'=>'Car Deleted Successfully'],200);
        }
    }

    public function getAgentCars($agent_id){
        $cars = Car::where('agent_id', $agent_id)->get();
        $data =$cars->map(function($car){
            return [
                'id' => $car->id,
                'category_name' => $car->category->name,
                'brand_name' => $car->brand->name,
                'model_name' => $car->model->name,
                'agent_id' => $car->agent_id,
                'agent_name' => $car->agent->name,
                'car_number' => $car->car_number,
                'car_color' => $car->car_color,
                'car_year' => $car->car_year,
                'status' => $car->status,
                'image' => $car->image ? asset('storage/' . $car->image) : null
            ];
        });
        return response()->json(['agent_cars'=>$data],200);
    }
}
