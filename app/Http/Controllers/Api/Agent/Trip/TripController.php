<?php

namespace App\Http\Controllers\Api\Agent\Trip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trip;
use App\Models\Station;
use App\Models\City;
use App\Models\Zone;
use App\Models\Country;

class TripController extends Controller
{
    public function __construct(private Trip $trip, private Station $stations,
    private City $cities, private Zone $zones, private Country $countries){}

    public function view(Request $request){
        $trips = $this->trip
        ->where('agent_id', $request->user()->id)
        ->with(['bus.busType', 'city', 'to_city', 'zone', 'to_zone',
        'pickup_station', 'dropoff_station', 'currency', 'country'])
        ->get()
        ->map(function($item){
            return [
                'deputre_time' => $item->deputre_time,
                'arrival_time' => $item->arrival_time,
                'avalible_seats' => $item->avalible_seats,
                'date' => $item->date,
                'price' => $item->price,
                'status' => $item->status,
                'max_book_date' => $item->max_book_date,
                'type' => $item->type,
                'fixed_date' => $item->fixed_date,
                'cancellation_policy' => $item->cancellation_policy,
                'cancelation_pay_amount' => $item->cancelation_pay_amount,
                'cancelation_pay_value' => $item->cancelation_pay_value,
                'min_cost' => $item->min_cost,
                'trip_type' => $item->trip_type,
                'cancelation_date' => $item->cancelation_date,
                'bus_image' => $item?->bus?->image_link ?? null,
                'bus_type' => $item?->bus?->busType?->name ?? null,
                'bus_capacity' => $item?->bus?->capacity ?? null,
                'country' => $item?->country?->name ?? null,
                'from_city' => $item?->city?->name ?? null,
                'from_zone' => $item?->zone?->name ?? null,
                'to_city' => $item?->to_city?->name ?? null,
                'to_zone' => $item?->to_zone?->name ?? null,
                'pickup_station' => $item?->pickup_station?->name ?? null,
                'dropoff_station' => $item?->dropoff_station?->name ?? null,
                'currency' => $item?->currency?->name ?? null,
            ];
        });
        $stations = $this->stations
        ->get();
        $cities = $this->cities
        ->get();
        $zones = $this->zones
        ->get();
        $countries = $this->countries
        ->get();
        return response()->json([
            'trips' => $trips,
            'stations' => $stations,
            'cities' => $cities,
            'zones' => $zones,
            'countries' => $countries,
        ]);
    }

    public function trip(Request $request, $id){
        $trips = $this->trip
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->with(['bus.busType', 'city', 'to_city', 'zone', 'to_zone',
        'pickup_station', 'dropoff_station', 'currency', 'country'])
        ->first();
        $trips = collect([$trips]);
        $trips->map(function($item){
            return [
                'deputre_time' => $item->deputre_time,
                'arrival_time' => $item->arrival_time,
                'avalible_seats' => $item->avalible_seats,
                'date' => $item->date,
                'price' => $item->price,
                'status' => $item->status,
                'max_book_date' => $item->max_book_date,
                'type' => $item->type,
                'fixed_date' => $item->fixed_date,
                'cancellation_policy' => $item->cancellation_policy,
                'cancelation_pay_amount' => $item->cancelation_pay_amount,
                'cancelation_pay_value' => $item->cancelation_pay_value,
                'min_cost' => $item->min_cost,
                'trip_type' => $item->trip_type,
                'cancelation_date' => $item->cancelation_date,
                'bus_image' => $item?->bus?->image_link ?? null,
                'bus_type' => $item?->bus?->busType?->name ?? null,
                'bus_capacity' => $item?->bus?->capacity ?? null,
                'country' => $item?->country?->name ?? null,
                'from_city' => $item?->city?->name ?? null,
                'from_zone' => $item?->zone?->name ?? null,
                'to_city' => $item?->to_city?->name ?? null,
                'to_zone' => $item?->to_zone?->name ?? null,
                'pickup_station' => $item?->pickup_station?->name ?? null,
                'dropoff_station' => $item?->dropoff_station?->name ?? null,
                'currency' => $item?->currency?->name ?? null,
            ];
        });
        $trip = count($trips) > 0 ? $trips[0] : null;

        return response()->json([
            'trip' => $trip
        ]);
    }

    public function create(){
        
    }

    public function modify(){
        
    }

    public function delete(){
        
    }
}
