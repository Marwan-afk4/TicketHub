<?php

namespace App\Http\Controllers\Api\Agent\Hiace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Image;

use App\Models\Bus;
use App\Models\BusType;
use App\Models\Aminity;

class HiaceController extends Controller
{
    public function __construct(private Bus $buses,
    private BusType $bus_type, private Aminity $aminities){}
    use Image;

    public function view(Request $request){
        // /agent/hiace
        $hiace_type = $this->bus_type
        ->get();
        $hiaces = $this->buses
        ->where('agent_id', $request->user()->id)
        ->where('type', 'hiace')
        ->with('busType', 'aminity')
        ->get();
        $aminities = $this->aminities
        ->get();

        return response()->json([
            'hiace_type' => $hiace_type,
            'hiaces' => $hiaces,
            'aminities' => $aminities,
        ]);
    }

    public function hiace(Request $request, $id){ 
        // /agent/hiace/item/{id}
        $hiace = $this->buses
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->with('busType', 'aminity')
        ->first();

        return response()->json([
            'hiace' => $hiace,
        ]);
    }

    public function create(Request $request){
        // /agent/hiace/add
        // Keys
        // bus_number, bus_type_id, capacity, status => [active, inactive]
        // bus_image, aminities[]
        $validation = Validator::make(request()->all(),[ 
            'bus_number' => 'required',
            'bus_type_id' => 'required|exists:bus_types,id',
            'capacity' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        } 
        $validation2 = Validator::make(request()->all(),[ 
            'aminities.*' => 'required|exists:aminities,id',
        ]);
        if($validation2->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }  
        $busRequest = $validation->validated();
        if ($request->bus_image && !is_string($request->bus_image)) {
            $image_path = $this->upload_image($request, 'bus_image', '/agent/hiace');
            $busRequest['bus_image'] = $image_path;
        }
        $busRequest['agent_id'] = $request->user()->id;
        $busRequest['type'] = 'hiace';
        $bus = $this->buses
        ->create($busRequest);
        if($request->aminities){
            $bus->aminity()->sync($request->aminities);
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        // /agent/hiace/update/{id}
        // Keys
        // bus_number, bus_type_id, capacity, status => [active, inactive]
        // bus_image, aminities[]
        $validation = Validator::make(request()->all(),[ 
            'bus_number' => 'sometimes',
            'bus_type_id' => 'required|exists:bus_types,id',
            'capacity' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $validation2 = Validator::make(request()->all(),[ 
            'aminities.*' => 'required|exists:aminities,id',
        ]);
        if($validation2->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $busRequest = $validation->validated();
        $bus = $this->buses
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->first();
        if (empty($bus)) {
            return response()->json([
                'errors' => 'item is not found'
            ], 400);
        }
        if ($request->bus_image && !is_string($request->bus_image)) {
            $image_path = $this->update_image($request, $bus->bus_image, 'bus_image', '/agent/hiace');
            $busRequest['bus_image'] = $image_path;
        }
        $bus->update($busRequest);
        if($request->aminities){
            $bus->aminity()->sync($request->aminities);
        }
        else{
            $bus->aminity()->sync([]);
        }

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        // /agent/hiace/delete/{id}
        $bus = $this->buses
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->first();
        if (empty($bus)) {
            return response()->json([
                'errors' => 'item is not found'
            ], 400);
        }
        $this->deleteImage($bus->bus_image);
        $bus->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
