<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\BusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusTypeController extends Controller
{
    use Image;

    public function getBusType(){
        $bus_type = BusType::all();
        $data = $bus_type->map(function($bus_type){
            return [
                'id' => $bus_type->id,
                'name' => $bus_type->name,
                'bus_image'=> url('storage/'.$bus_type->bus_image) ?? null,
                'seat_count' => $bus_type->seat_count,
                'plan_image' => url('storage/'.$bus_type->plan_image) ?? null,
                'seats_image' => url('storage/'.$bus_type->seats_image) ?? null,
                'status' => $bus_type->status
            ];
        });
        return response()->json(['bus_type' => $data]);
    }

    public function addBusType(Request $request){
        $validation = Validator::make(request()->all(),[
            'name' => 'required|string',
            'bus_image' => 'required|string',
            'plan_image' => 'required|string',
            'seats_image' => 'required|string',
            'seat_count' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],400);
        }

        $bustype = BusType::create([
            'name' => $request->name,
            'bus_image' => $this->storeBase64Image($request->bus_image , 'admin/bus_type/bus'),
            'plan_image' => $this->storeBase64Image($request->plan_image , 'admin/bus_type/plan'),
            'seats_image' => $this->storeBase64Image($request->seats_image , 'admin/bus_type/seats'),
            'seat_count' => $request->seat_count,
            'status' => $request->status,
        ]);
        return response()->json(['message'=>'Bus Type Created Successfully'],200);
    }

    public function updateBusType(Request $request, $id){
        $bustype = BusType::find($id);
        if(!$bustype){
            return response()->json(['message'=>'bus type not found']);
        }

        if($request->has('bus_image')) {
            $bustype->bus_image = $this->storeBase64Image($request->bus_image, 'admin/bus_type/bus');
        }

        if($request->has('plan_image')) {
            $bustype->plan_image = $this->storeBase64Image($request->plan_image, 'admin/bus_type/plan');
        }

        if($request->has('seats_image')) {
            $bustype->seats_image = $this->storeBase64Image($request->seats_image, 'admin/bus_type/seats');
        }
        $bustype->update([
            'name' => $request->name ?? $bustype->name,
            'bus_image' => $request->bus_image ?? $bustype->bus_image,
            'status' => $request->status ?? $bustype->status,
        ]);
        return response()->json(['message'=>'Bus Type Updated Successfully'],200);
    }

    public function deleteBusType($id){
        $bustype = BusType::find($id);
        if(!$bustype){
            return response()->json(['message'=>'bus type not found']);
        }
        $bustype->delete();
        return response()->json(['message'=>'Bus Type Deleted Successfully'],200);
    }


}
