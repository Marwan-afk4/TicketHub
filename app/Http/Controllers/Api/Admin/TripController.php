<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use App\Models\TripDays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{

    public function getTrips()
    {
        $trips = Trip::with([
            'bus',
            'city',
            'to_city',
            'zone',
            'pickup_station',
            'dropoff_station'
        ])->get();

        $data = $trips->map(function ($trip) {
            return [
                'id' => $trip->id,
                'name' => $trip->trip_name ?? 'Unnamed Trip',
                'status' => $trip->status,
                'trip_type' => $trip->trip_type,
                'date' => $trip->date,
                'departure_time' => $trip->deputre_time,
                'arrival_time' => $trip->arrival_time,
                'max_booking_date' => $trip->max_book_date,
                'price' => $trip->price,
                'min_cost' => $trip->min_cost,
                'currency_id' => $trip->currency_id,
                'currency_name' => $trip->currency->name,
                'currency_sympol' => $trip->currency->symbol,
                'available_seats' => $trip->avalible_seats,
                'type' => $trip->type,

                'cancellation_policy' => [
                    'policy' => $trip->cancellation_policy,
                    'pay_amount' => $trip->cancelation_pay_amount,
                    'pay_value' => $trip->cancelation_pay_value,
                    'cancelation_hours' => $trip->cancelation_hours
                ],

                'agent' => [
                    'id' => $trip->agent_id
                ],

                'bus' => $trip->bus ? [
                    'id' => $trip->bus->id,
                    'number' => $trip->bus->bus_number,
                    'type_id' => $trip->bus->bus_type_id,
                    'capacity' => $trip->bus->capacity,
                    'status' => $trip->bus->status,
                    'image' => [
                        'path' => $trip->bus->bus_image,
                        'url' => $trip->bus->bus_image ? asset('storage/' . $trip->bus->bus_image) : null
                    ]
                ] : null,

                'route' => [
                    'origin' => [
                        'country_id' => $trip->country_id,
                        'country_name' => $trip->country->name,
                        'city' => $trip->city ? [
                            'id' => $trip->city->id,
                            'name' => $trip->city->name,
                            'status' => $trip->city->status
                        ] : null,
                        'zone' => $trip->zone ? [
                            'id' => $trip->zone->id,
                            'name' => $trip->zone->name
                        ] : null,
                        'pickup_station' => $trip->pickup_station ? [
                            'id' => $trip->pickup_station->id,
                            'name' => $trip->pickup_station->name,
                            'zone_id' => $trip->pickup_station->zone_id
                        ] : null
                    ],
                    'destination' => [
                        'country_id' => $trip->to_country_id,
                        'country_name' => $trip->to_country->name,
                        'city' => $trip->to_city ? [
                            'id' => $trip->to_city->id,
                            'name' => $trip->to_city->name,
                            'status' => $trip->to_city->status
                        ] : null,
                        'zone' => $trip->to_zone_id ? [
                            'id' => $trip->to_zone_id,
                            'name' => 'Zone ' . $trip->to_zone_id
                        ] : null,
                        'dropoff_station' => $trip->dropoff_station ? [
                            'id' => $trip->dropoff_station->id,
                            'name' => $trip->dropoff_station->name,
                            'zone_id' => $trip->dropoff_station->zone_id
                        ] : null
                    ],
                    'intermediate_stations' => array_filter([
                        ['station_1' => $trip->station_1],
                        ['station_2' => $trip->station_2],
                        ['station_3' => $trip->station_3],
                        ['station_4' => $trip->station_4]
                    ], function ($station) {
                        return !is_null(current($station));
                    })
                ],
            ];
        });

        return response()->json(['trips' => $data]);
    }



    public function addTrip(TripRequest $request)
    {
        $trip = Trip::create($request->validated());

        $validated = $request->validated();
        $days = $validated['day'] ?? [];

        if (!empty($days) && is_array($days)) {
            foreach ($days as $day) {
                TripDays::create([
                    'trip_id' => $trip->id,
                    'day' => $day
                ]);
            }
        }

        return response()->json([
            'message' => 'Trip created successfully',
            'trip' => $trip
        ]);
    }


    public function updateTrip(TripRequest $request, $id)
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $validated = $request->validated();
        $trip->update($validated);

        $days = $validated['day'] ?? [];

        if (!empty($days) && is_array($days)) {
            // delete old days using the relationship
            $trip->days()->delete();

            // add new days
            foreach ($days as $day) {
                TripDays::create([
                    'trip_id' => $trip->id,
                    'day' => $day
                ]);
            }
        }

        return response()->json([
            'message' => 'Trip updated successfully',
            'trip' => $trip
        ]);
    }




    public function deleteTrip($id)
    {
        $trip = Trip::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $trip->delete();

        return response()->json(['message' => 'Trip deleted successfully']);
    }
}
