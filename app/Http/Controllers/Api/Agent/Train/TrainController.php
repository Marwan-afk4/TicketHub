<?php

namespace App\Http\Controllers\Api\Agent\Train;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Agent\TrainRequest;

use App\Models\Train;
use App\Models\TrainClass;
use App\Models\TrainRoute;
use App\Models\TrainType;
use App\Models\Country;

class TrainController extends Controller
{
    public function __construct(
        private Train $trains, 
        private TrainClass $class, 
        private TrainRoute $route,
        private TrainType $train_types,
        private Country $country){}

    public function view(Request $request){
        // /agent/train
        $classes = $this->class
        ->get();
        $trains = $this->trains
        ->where('agent_id', $request->user()->id)
        ->with([
            'type', 
            'class', 
            'country', 
            'route' => function ($query) {
                $query->with(['from_country', 'from_city', 'to_country', 'to_city']);
            }
        ])
        ->get();
    
        $routes = $this->route
        ->with(['from_country', 'from_city', 'to_country', 'to_city'])
        ->get();
        $train_types = $this->train_types
        ->get();
        $countries = $this->country
        ->get();

        return response()->json([
            'classes' => $classes,
            'trains' => $trains,
            'routes' => $routes,
            'train_types' => $train_types,
            'countries' => $countries,
        ]);
    }

    public function train(Request $request, $id){
        // /agent/train/item/{id}
        $train = $this->trains
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->with([
            'type', 
            'class', 
            'country', 
            'route' => function ($query) {
                $query->with(['from_country', 'from_city', 'to_country', 'to_city']);
            }
        ])
        ->first();

        return response()->json([
            'train' => $train
        ]);
    }

    public function status(Request $request, $id){
        // /agent/train/status/{id}
        // Keys
        // status
        $validation = Validator::make(request()->all(),[
            'status' => 'required|boolean',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $train = $this->trains
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => $request->status ? 'active' : 'banned'
        ]);
    }

    public function create(TrainRequest $request){
        // /agent/train/add
        // Keys
        // name, type_id, class_id, country_id, route_id, status
        $trainRequest = $request->validated();
        $trainRequest['agent_id'] = $request->user()->id;
        $this->trains
        ->create($trainRequest);

        return response()->json([
            'success' => 'You add data success',
        ]);
    }

    public function modify(TrainRequest $request, $id){
        // /agent/train/update/{id}
        // Keys
        // name, type_id, class_id, country_id, route_id, status
        $trainRequest = $request->validated();
        $this->trains
        ->where('id', $id)
        ->update($trainRequest);

        return response()->json([
            'success' => 'You update data success',
        ]);
    }

    public function delete(Request $request, $id){
        // /agent/train/delete/{id}
        $this->trains
        ->where('id', $id)
        ->where('agent_id', $request->user()->id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success',
        ]);
    }
}
