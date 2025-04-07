<?php

namespace App\Http\Controllers\Api\Agent\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

class BookingReportController extends Controller
{
    public function __construct(private Payment $payments){}

    public function view(Request $request){
        // /agent/report/booking
        $bookings = $this->payments
        ->select('id', 'amount', 'total', 'status', 'travelers', 'travel_date', 'trip_id', 
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
            $item->trip_type = $item?->trip?->trip_type ?? null;
            $item->travel_status = $item?->booking?->status ?? null;
            $item->operator = $item->total - $item->commission;
            $item->makeHidden(['booking', 'booking_id', 'commission', 'total']);
            return $item;
        });

        return response()->json([
            'bookings' => $bookings
        ]);
    }
}
