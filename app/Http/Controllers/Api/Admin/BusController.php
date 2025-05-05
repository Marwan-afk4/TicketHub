<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusController extends Controller
{
    use Image;

    public function getAgents(){
        $agents = User::where('role', 'agent')->get();
        return response()->json(['agents' => $agents]);
    }


    public function getBus()
{
    $buses = Bus::with(['agent', 'busType', 'amenities'])
    ->where('type', 'bus')
    ->get();

    $data = $buses->map(function ($bus) {
        return [
            'id' => $bus->id,
            'agent_id' => $bus->agent_id,
            'agent_name' => $bus->agent->name ?? null,
            'agent_email' => $bus->agent->email ?? null,
            'bus_number' => $bus->bus_number,
            'bus_image' => $bus->bus_image ? asset('storage/' . $bus->bus_image) : null,
            'bus_type_id' => $bus->bus_type_id,
            'bus_type_name' => $bus->busType->name ?? null,
            'capacity' => $bus->capacity,
            'status' => $bus->status,
            'type' => $bus->type,
            'amenities' => $bus->amenities->map(function ($amenity) {
                return [
                    'id' => $amenity->id,
                    'name' => $amenity->name,
                ];
            }),
        ];
    });

    return response()->json(['buses' => $data]);
}

public function getHiace()
{
    $buses = Bus::with(['agent', 'busType', 'amenities'])
    ->where('type', 'hiace')
    ->get();

    $data = $buses->map(function ($bus) {
        return [
            'id' => $bus->id,
            'agent_id' => $bus->agent_id,
            'agent_name' => $bus->agent->name ?? null,
            'agent_email' => $bus->agent->email ?? null,
            'bus_number' => $bus->bus_number,
            'bus_image' => $bus->bus_image ? asset('storage/' . $bus->bus_image) : null,
            'bus_type_id' => $bus->bus_type_id,
            'bus_type_name' => $bus->busType->name ?? null,
            'capacity' => $bus->capacity,
            'status' => $bus->status,
            'type' => $bus->type,
            'amenities' => $bus->amenities->map(function ($amenity) {
                return [
                    'id' => $amenity->id,
                    'name' => $amenity->name,
                ];
            }),
        ];
    });

    return response()->json(['hiaces' => $data]);
}



    public function addBus(Request $request){
        $validation = Validator::make(request()->all(),[
            'bus_number' => 'required',
            'bus_type_id' => 'nullable|exists:bus_types,id',
            'bus_image' => 'nullable',
            'capacity' => 'required',
            'agent_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
            'type'=>'required|in:bus,hiace',
            'aminty_id' => 'nullable|array',
            'aminty_id.*' => 'exists:aminities,id'
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 400);
        }

        $busImagePath = null;

        if ($request->has('bus_image')) {
            $busImagePath = $this->storeBase64Image($request->bus_image, 'admin/bus/images');
        }

        $bus = Bus::create([
            'bus_number' => $request->bus_number,
            'bus_type_id' => $request->bus_type_id??null,
            'bus_image' => $busImagePath,
            'capacity' => $request->capacity,
            'agent_id' => $request->agent_id,
            'status' => $request->status,
            'type'=>$request->type
        ]);

        if ($request->has('aminty_id') && is_array($request->aminty_id)) {
            $amintyData = [];
            foreach ($request->aminty_id as $aminty) {
                $amintyData[] = [
                    'bus_id' => $bus->id,
                    'aminity_id' => $aminty,
                ];
            }
            DB::table('aminity_bus')->insert($amintyData);
        }

        return response()->json([
            'message' => 'Bus Created Successfully',
            'bus' => $bus
        ]);
    }

    public function deleteBus($id){
        $bus = Bus::find($id);
        if (!$bus) {
            return response()->json(['errors' => 'Bus not found'], 404);
        }
        $bus->delete();
        return response()->json(['message' => 'Bus Deleted Successfully']);
    }



    public function updateBus(Request $request, $id){
        $bus = Bus::find($id);

        if (!$bus) {
            return response()->json(['errors' => 'Bus not found'], 404);
        }

        $bus->update([
            'bus_number' => $request->bus_number ?? $bus->bus_number,
            'bus_type_id' => $request->bus_type_id ?? $bus->bus_type_id,
            'capacity' => $request->capacity ?? $bus->capacity,
            'agent_id' => $request->agent_id ?? $bus->agent_id,
            'status' => $request->status ?? $bus->status,
            'type'=>$request->type ?? $bus->type
        ]);

        if ($request->has('bus_image')) {
            $busImagePath = $this->storeBase64Image($request->bus_image, 'admin/bus/images');
            $bus->bus_image = $busImagePath;
            $bus->save();
        }

        DB::table('aminity_bus')
        ->where('bus_id', $id)
        ->delete();
        if ($request->has('aminty_id') && is_array($request->aminty_id)) {
            $amintyData = [];
            foreach ($request->aminty_id as $aminty) {
                $amintyData[] = [
                    'bus_id' => $bus->id,
                    'aminity_id' => $aminty,
                ];
            }
            DB::table('aminity_bus')->insert($amintyData);
        }

        return response()->json([
            'message' => 'Bus updated successfully',
            'bus' => $bus,
        ]);
    }

}
