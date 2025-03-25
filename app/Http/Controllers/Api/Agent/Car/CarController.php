<?php

namespace App\Http\Controllers\Api\Agent\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\CarModel;
use App\Models\Car;

class CarController extends Controller
{
    public function __construct(private CarBrand $brands,
    private CarCategory $category, private CarModel $car_mode,
    private Car $car){}

    public function view(Request $request){
        $cars = $this->car
        ->where('agent_id', $request->user()->id);
    }
}
