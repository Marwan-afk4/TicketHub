<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\City;
use App\Models\Trip;

class BookingController extends Controller
{
    public function __construct(private City $cities, 
    private Trip $trips){}

    public function lists(){
        // user/booking/lists
        $cities = $this->cities
        ->select('id', 'name')
        ->where('status', 'active')
        ->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function filter(Request $request){
        // user/booking
        // Keys
        // from, to, date, travelers, type => [one_way, round_trip]
        $validation = Validator::make(request()->all(),[ 
            'from' => 'nullable|exists:cities,id',
            'to' => 'nullable|exists:cities,id',
            'date' => 'date|nullable',
            'travelers' => 'numeric|nullable',
            'type' => 'nullable|in:one_way,round_trip',
        ]);
        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],400);
        }

        $buses_trips = $this->trips
        ->with(['bus:id,bus_number', 'pickup_station:id,name',
        'dropoff_station:id,name'])
        ->where('avalible_seats', '>', 0)
        ->where('status', 'active')
        ->get();
        if ($request->from && !empty($request->from)) {
            $buses_trips = $buses_trips->where('city_id', $request->from);
        }
        if ($request->to && !empty($request->to)) {
            $buses_trips = $buses_trips->where('to_city_id', $request->to);
        }
        if ($request->date && !empty($request->date)) {
            $buses_trips = $buses_trips->where('date', $request->date);
        }
        if ($request->travelers && !empty($request->travelers)) {
            $buses_trips = $buses_trips->where('avalible_seats', '>=', $request->travelers);
        }
        $buses_trips = $buses_trips->values();
        if ($request->type && $request->type == 'round_trip') {
            $buses_back_trips = $this->trips
            ->with(['bus:id,bus_number', 'pickup_station:id,name',
            'dropoff_station:id,name'])
            ->where('avalible_seats', '>', 0)
            ->where('status', 'active')
            ->get();
            if ($request->from && !empty($request->from)) {
                $buses_back_trips = $buses_back_trips->where('to_city_id', $request->from);
            }
            if ($request->to && !empty($request->to)) {
                $buses_back_trips = $buses_back_trips->where('city_id', $request->to);
            }
            if ($request->date && !empty($request->date)) {
                $buses_back_trips = $buses_back_trips->where('date', $request->date);
            }
            if ($request->travelers && !empty($request->travelers)) {
                $buses_back_trips = $buses_back_trips->where('avalible_seats', '>=', $request->travelers);
            }
            $buses_back_trips = $buses_back_trips->values();
            $buses_trips = $buses_trips->merge($buses_back_trips);
        }
        $buses_trips = $buses_trips->select('id', 'bus', 'pickup_station', 'dropoff_station',
        'trip_name', 'deputre_time', 'arrival_time', 'date', 'avalible_seats', 'price');

        return response()->json([
            'buses_trips' => $buses_trips,
        ]);
    }
}
