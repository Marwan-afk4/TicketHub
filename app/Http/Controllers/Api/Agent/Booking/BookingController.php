<?php

namespace App\Http\Controllers\Api\Agent\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Payment;
use App\Models\Booking;

class BookingController extends Controller
{
    public function __construct(private Booking $bookings, private Payment $payments){}

    public function view(Request $request){
        // /agent/bookings 
        $bookings = $this->payments
        ->select('amount', 'total', 'status', 'travelers', 'travel_date', 'trip_id', 
        'booking_id', 'user_id', 'commission', 'currency_id')
        ->with(['trip' => function($query){
            $query->select('id', 'trip_name', 'deputre_time', 'arrival_time', 'pickup_station_id', 
            'dropoff_station_id', 'city_id', 'to_city_id', 'trip_type')
            ->with([
                'pickup_station:id,name', 'dropoff_station:id,name',
                'city:id,name', 'to_city:id,name'
            ]);
        }, 'user:id,name,phone', 'currency:id,name'])
        ->where('agent_id', $request->user()->id)
        ->where('status', 'confirmed')
        ->get()
        ->map(function($item){
            $item->booking = $item?->booking?->id;
            $item->trip_type = $item?->trip?->trip_type ?? null;
            $item->travel_status = $item?->booking?->status ?? null;
            $item->operator = $item->total - $item->commission;
            $item->makeHidden(['booking', 'booking_id', 'commission', 'total']);
            return $item;
        });
        $pending_booking = $bookings
        ->where('travel_status', 'pending');
        $confirmed_booking = $bookings
        ->where('travel_status', 'confirmed');
        $canceled_booking = $bookings
        ->where('travel_status', 'canceled'); 
        
        return response()->json([
            'pending_booking' => $pending_booking->values(),
            'confirmed_booking' => $confirmed_booking->values(),
            'canceled_booking' => $canceled_booking->values(),
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
