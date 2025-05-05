<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainController extends Controller
{
    public function getTrains(){
        $trains = Train::with('type','route','country','class','agent')->get();
        $data =$trains->map(function($train){
            return [
                'id' => $train->id,
                'name' => $train->name,
                'type_id' => $train->type_id,
                'type' => $train->type->name,
                'route_id' => $train->route_id,
                'route' => $train->route->name,
                'country_id' => $train->country_id,
                'country' => $train->country->name,
                'class_id' => $train->class_id,
                'class' => $train->class->name,
                'agent_id' => $train->agent_id,
                'agent' => $train->agent->name,
                'status' => $train->status,
            ];
        });
        return response()->json(['train'=>$data]);
    }

    public function addtrain(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'agent_id' => ['required', 'exists:users,id'],
            'type_id' => ['required', 'exists:train_types,id'],
            'route_id' => ['required', 'exists:train_routes,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'class_id' => ['required', 'exists:train_classes,id'],
            'status' => ['required', 'boolean'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $train = Train::create([
            'name' => $request->name,
            'agent_id' => $request->agent_id,
            'type_id' => $request->type_id,
            'route_id' => $request->route_id,
            'country_id' => $request->country_id,
            'class_id' => $request->class_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Train Created Successfully',
            'train' => $train
        ]);
    }

    public function modifytrain(Request $request, $id){
        $validation = Validator::make($request->all(),[
            'name' => ['nullable', 'string'],
            'agent_id' => ['nullable', 'exists:users,id'],
            'type_id' => ['nullable', 'exists:train_types,id'],
            'route_id' => ['nullable', 'exists:train_routes,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'class_id' => ['nullable', 'exists:train_classes,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $train = Train::find($id);
        $train->update([
            'name' => $request->name ?? $train->name,
            'agent_id' => $request->agent_id ?? $train->agent_id,
            'type_id' => $request->type_id ?? $train->type_id,
            'route_id' => $request->route_id ?? $train->route_id,
            'country_id' => $request->country_id ?? $train->country_id,
            'class_id' => $request->class_id ?? $train->class_id,
            'status' => $request->status ?? $train->status,
        ]);

        return response()->json([
            'message' => 'Train Updated Successfully',
            'train' => $train
        ]);
    }

    public function deletetrain($id){
        $train = Train::find($id);
        $train->delete();
        return response()->json([
            'message' => 'Train Deleted Successfully'
        ]);
    }
}
