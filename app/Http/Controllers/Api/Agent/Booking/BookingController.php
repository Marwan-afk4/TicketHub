<?php

namespace App\Http\Controllers\Api\Agent\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Booking;

class BookingController extends Controller
{
    public function __construct(private Booking $bookings){}

    public function view(Request $request){
        // /agent/bookings 
        $pending_booking = $this->bookings
        ->where('status', 'pending')
        ->where('agent_id', $request->user()->id)
        ->with(['bus:id,bus_image,bus_number', 'trip:id,trip_name',
        'train:id,name'])
        ->get();
        $confirmed_booking = $this->bookings
        ->where('status', 'confirmed')
        ->where('agent_id', $request->user()->id)
        ->with(['bus:id,bus_image,bus_number', 'trip:id,trip_name',
        'train:id,name'])
        ->get();
        $canceled_booking = $this->bookings
        ->where('status', 'canceled')
        ->where('agent_id', $request->user()->id)
        ->with(['bus:id,bus_image,bus_number', 'trip:id,trip_name',
        'train:id,name'])
        ->get();
        
        return response()->json([
            'pending_booking' => $pending_booking,
            'confirmed_booking' => $confirmed_booking,
            'canceled_booking' => $canceled_booking,
        ]);
    }
    
    public function status(Request $request, $id){
        // /agent/bookings/status/{id}
        // Keys
        // status => [confirmed, canceled, pending]
        $validation = Validator::make(request()->all(),[
            'status' => 'required|in:confirmed,canceled,pending',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $this->bookings
        ->where('id', $id)
        ->where('agent_id', $request->user()->id)
        ->update([
            'status' => $request->status
        ]);
        
        return response()->json([
            'success' => $request->status,
        ]);
    }
}
