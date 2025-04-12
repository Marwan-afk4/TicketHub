<?php

namespace App\Http\Controllers\Api\Agent\Trip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Agent\TripRequest;

use App\Models\Trip;
use App\Models\Station;
use App\Models\City;
use App\Models\Zone;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Bus;
use App\Models\TripDays;
use App\Models\Train;

class TripController extends Controller
{
    public function __construct(private Trip $trip, private Station $stations,
    private City $cities, private Zone $zones, private Country $countries,
    private Currency $currency, private Bus $buses, private Train $trains,
    private TripDays $trip_days){}

    public function view(Request $request){
        // /agent/trip
        $trips = $this->trip
        ->where('agent_id', $request->user()->id)
        ->with(['bus.busType', 'city', 'to_city', 'zone', 'to_zone',
        'pickup_station', 'dropoff_station', 'currency', 'country',
        'to_country', 'train' => function($query){
            $query->select('id', 'name', 'class_id', 'type_id')
            ->with(['type:id,name', 'class:id,name']);
        }])
        ->get()
        ->map(function($item){
            return [
                'id' => $item->id,
                'trip_name' => $item->trip_name,
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
                'cancelation_hours' => $item->cancelation_hours,
                'bus_image' => $item?->bus?->image_link ?? null,
                'bus_type' => $item?->bus?->busType?->name ?? null,
                'bus_capacity' => $item?->bus?->capacity ?? null,
                'train_name' => $item?->train?->name ?? null,
                'train_type' => $item?->train?->type?->name ?? null,
                'train_class' => $item?->train?->class?->name ?? null,
                'from_country' => $item?->country?->name ?? null,
                'from_city' => $item?->city?->name ?? null,
                'from_zone' => $item?->zone?->name ?? null,
                'to_country' => $item?->to_country?->name ?? null,
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
        $currency = $this->currency
        ->get();
        $trains = $this->trains
        ->where('agent_id', $request->user()->id)
        ->with(['type', 'class', 'country', 'route' => function($query){
            $query->with(['from_country', 'from_city', 'to_country', 'to_city']);
        }])
        ->get();
        $buses = $this->buses
        ->where('agent_id', $request->user()->id)
        ->with('busType')
        ->get();
        $hiaces = $buses->where('type', 'hiace')->values();
        $buses = $buses->where('type', 'bus')->values();
        return response()->json([
            'trips' => $trips,
            'stations' => $stations,
            'cities' => $cities,
            'zones' => $zones,
            'countries' => $countries,
            'currency' => $currency,
            'buses' => $buses,
            'hiaces' => $hiaces,
            'trains' => $trains,
        ]);
    }

    public function trip(Request $request, $id){
        // /agent/trip/item/{id}
        $trips = $this->trip
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->with(['bus.busType', 'city', 'to_city', 'zone', 'to_zone',
        'pickup_station', 'dropoff_station', 'currency', 'country', 
        'train' => function($query){
            $query->select('id', 'name', 'class_id', 'type_id')
            ->with(['type:id,name', 'class:id,name']);
        }])
        ->first();
        $trips = collect([$trips]);
        $trips->map(function($item){
            return [
                'deputre_time' => $item->deputre_time,
                'trip_name' => $item->trip_name,
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
                'cancelation_hours' => $item->cancelation_hours,
                'bus_id' => $item?->bus?->id ?? null,
                'bus_image' => $item?->bus?->image_link ?? null,
                'bus_type' => $item?->bus?->busType?->name ?? null,
                'bus_capacity' => $item?->bus?->capacity ?? null,
                'train_id' => $item?->train?->id ?? null,
                'train_name' => $item?->train?->name ?? null,
                'train_type' => $item?->train?->type?->name ?? null,
                'train_class' => $item?->train?->class?->name ?? null,
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

    public function create(TripRequest $request){
        // /agent/trip/add
        // Keys
        //  trip_name, bus_id, pickup_station_id, dropoff_station_id, city_id, 
        // zone_id, deputre_time, arrival_time, avalible_seats, country_id, 
        // to_country_id, to_city_id, to_zone_id, date, price, status => [active, inactive], 
        // max_book_date, type => [limited, unlimited], fixed_date, cancellation_policy, 
        // cancelation_pay_amount => [fixed, percentage], cancelation_pay_value, 
        // min_cost, trip_type => [hiace, bus, train], currency_id, cancelation_hours,
        // start_date, days['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
        // train_id
        $tripRequest = $request->validated();
        $tripRequest['agent_id'] = $request->user()->id;
        $trip = $this->trip->create($tripRequest);
        if ($request->days) {
            foreach ($request->days as $item) {
                $this->trip_days
                ->create([
                    'day' => $item,
                    'trip_id' => $trip->id
                ]);
            }
        }

        return response()->json([
            'success' => 'You add data successfully',
            'trip' => $trip
        ]);
    }

    public function modify(TripRequest $request, $id){
        // /agent/trip/update/{id}
        // Keys
        //  trip_name, bus_id, pickup_station_id, dropoff_station_id, city_id, 
        // zone_id, deputre_time, arrival_time, avalible_seats, country_id, 
        // to_country_id, to_city_id, to_zone_id, date, price, status, 
        // max_book_date, type, fixed_date, cancellation_policy, cancelation_pay_amount, 
        // cancelation_pay_value, min_cost, trip_type, currency_id, cancelation_hours,
        // start_date, days['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
        // train_id
        $trip = $this->trip->find($id);

        if (!$trip) {
            return response()->json(['errors' => 'Trip not found'], 404);
        }

        $trip->update($request->validated());
        $this->trip_days
        ->where('trip_id', $trip->id)
        ->delete();
        if ($request->days) {
            foreach ($request->days as $item) {
                $this->trip_days
                ->create([
                    'day' => $item,
                    'trip_id' => $trip->id
                ]);
            }
        }

        return response()->json([
            'success' => 'You update data successfully',
            'trip' => $trip
        ]);
    }

    public function delete(Request $request, $id){
        // /agent/trip/delete/{id}
        $trip = $this->trip
        ->where('agent_id', $request->user()->id)
        ->find($id);
        if (!$trip) {
            return response()->json(['errors' => 'Trip not found'], 404);
        }

        $trip->delete();

        return response()->json(['success' => 'You delete data successfully']);
    }
}
