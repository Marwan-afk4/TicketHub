<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Trip;

class TripRequestController extends Controller
{
    public function __construct(private Trip $trip){}

    public function view(){
        $pending_trips = $this->trip
        ->with('agent:id,name')
        ->where('request_status', 'pending')
        ->get();

        return response()->json([
            'pending_trips' => $pending_trips
        ]);
    }

    public function status(Request $request, $id){
        $validation = Validator::make(request()->all(),[
            'request_status' => 'required|in:approved,rejected',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $pending_trips = $this->trip
        ->where('id', $id)
        ->update([
            'request_status' => $request->request_status
        ]);

        return response()->json([
            'request_status' => $request->request_status
        ]);
    }
}
