<?php

namespace App\Http\Controllers\Api\Agent\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Agent\CarRequest;
use App\Image;

use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\CarModel;
use App\Models\Car;

class CarController extends Controller
{
    public function __construct(private CarBrand $brands,
    private CarCategory $category, private CarModel $car_models,
    private Car $car){}
    use Image;

    public function view(Request $request){
        // /agent/car
        $cars = $this->car
        ->where('agent_id', $request->user()->id)
        ->with(['category:id,name', 'brand:id,name', 'model:id,name'])
        ->get();
        $category = $this->category
        ->get();
        $brands = $this->brands
        ->get();
        $car_models = $this->car_models
        ->get();

        return response()->json([
            'cars' => $cars,
            'category' => $category,
            'brands' => $brands,
            'car_models' => $car_models,
        ]);
    }

    public function car(Request $request, $id){
        // /agent/car/item/{id}
        $car = $this->car
        ->where('id', $id)
        ->where('agent_id', $request->user()->id)
        ->with(['category:id,name', 'brand:id,name', 'model:id,name'])
        ->first();

        return response()->json([
            'car' => $car
        ]);
    }

    public function create(CarRequest $request){
        // /agent/car/add
        // Keys
        // category_id, brand_id, model_id, status => [busy, available], 
        // car_number, car_color, car_year, image, capacity
        $carRequest = $request->validated();
        $carRequest['agent_id'] = $request->user()->id;
        if ($request->image && !is_string($request->image)) {
            $image_path = $this->upload_image($request, 'image', '/agent/cars');
            $carRequest['image'] = $image_path;
        }
        $car = $this->car
        ->create($carRequest);

        return response()->json([
            'success' => 'You add data success',
        ]);
    }

    public function modify(CarRequest $request, $id){
        // /agent/car/update/{id}
        // Keys
        // category_id, brand_id, model_id, status => [busy, available], 
        // car_number, car_color, car_year, capacity
        $carRequest = $request->validated();
        $car = $this->car
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->first();
        if (empty($car)) {
            return response()->json([
                'errors' => 'item is not found'
            ], 400);
        }
        $carRequest['agent_id'] = $request->user()->id;
        if ($request->image && !is_string($request->image)) {
            $image_path = $this->update_image($request, $car->image, 'image', '/agent/cars');
            $carRequest['image'] = $image_path;
        }
        $car->update($carRequest);

        return response()->json([
            'success' => 'You update data success',
        ]);
    }

    public function delete(Request $request, $id){
        // /agent/car/delete/{id}
        $car = $this->car
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->first();
        if (empty($car)) {
            return response()->json([
                'errors' => 'item is not found'
            ], 400);
        }
        $this->deleteImage($car->image);
        $car->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
