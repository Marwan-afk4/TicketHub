<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainRouteController extends Controller
{


    public function getRoutes(){
        $routes = TrainRoute::with('from_country', 'from_city', 'to_country', 'to_city')->get();
        $data =$routes->map(function($route){
            return [
                'id' => $route->id,
                'name' => $route->name,
                'from_country_id' => $route->from_country_id,
                'from_country' => $route->from_country->name,
                'from_city_id' => $route->from_city_id,
                'from_city' => $route->from_city->name,
                'to_country_id' => $route->to_country_id,
                'to_country' => $route->to_country->name,
                'to_city_id' => $route->to_city_id,
                'to_city' => $route->to_city->name,
            ];
        });
        return response()->json([
            'routes' => $data
        ]);
    }

    public function addRoute(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'from_country_id' => ['required', 'exists:countries,id'],
            'from_city_id' => ['required', 'exists:cities,id'],
            'to_country_id' => ['required', 'exists:countries,id'],
            'to_city_id' => ['required', 'exists:cities,id'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $route = TrainRoute::create([
            'name' => $request->name,
            'from_country_id' => $request->from_country_id,
            'from_city_id' => $request->from_city_id,
            'to_country_id' => $request->to_country_id,
            'to_city_id' => $request->to_city_id,
        ]);
        return response()->json([
            'route' => $route
        ]);
    }

    public function updateRoute(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'name' => ['nullable', 'string'],
            'from_country_id	' => ['nullable', 'exists:countries,id'],
            'from_city_id' => ['nullable', 'exists:cities,id'],
            'to_country_id' => ['nullable', 'exists:countries,id'],
            'to_city_id' => ['nullable', 'exists:cities,id'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $route = TrainRoute::find($id);
        $route->update([
            'name' => $request->name,
            'from_country_id' => $request->from_country_id ?? $route->from_country_id,
            'from_city_id' => $request->from_city_id ?? $route->from_city_id,
            'to_country_id' => $request->to_country_id ?? $route->to_country_id,
            'to_city_id' => $request->to_city_id ?? $route->to_city_id,
        ]);
        return response()->json([
            'route' => $route
        ]);
    }

    public function deleteRoute($id){
        $route = TrainRoute::find($id);
        $route->delete();
        return response()->json([
            'route' => $route
        ]);
    }

}
