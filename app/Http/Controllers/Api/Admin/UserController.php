<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Currency;

class UserController extends Controller
{


    public function getUsers()
    {
        $users = User::where('role', 'user')
            ->with(['country', 'city', 'zone', 'bookings.bus', 'bookings.trip', 'bookings.bookingUsers'])
            ->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'country' => $user->country->name ?? null,
                'city_id' => $user->city_id,
                'city' => $user->city->name ?? null,
                'zone_id' => $user->zone_id,
                'zone' => $user->zone->name ?? null,
                'bookings' => $user->bookings->map(function ($booking) {
                    return [
                        'user_id' => $booking->user_id,
                        'agent_id' => $booking->agent_id,
                        'agent_name' => $booking->agent->name ?? null,
                        'agent_email' => $booking->agent->email ?? null,
                        'agent_phone' => $booking->agent->phone ?? null,
                        'agent_code'=> $booking->agent->code ?? null,
                        'bus_id' => $booking->bus_id,
                        'bus_name' => $booking->bus->bus_number ?? null,
                        'trip_id' => $booking->trip_id,
                        'trip_name' => $booking->trip->trip_name ?? null,
                        'country_residence_id' => $booking->trip->country_id ?? null,
                        'country_residence' => $booking->trip->country->name ?? null,
                        'city_residence_id' => $booking->trip->city_id ?? null,
                        'city_residence' => $booking->trip->city->name ?? null,
                        'to_country_id' => $booking->trip->to_country_id ?? null,
                        'to_country' => $booking->trip->to_country->name ?? null,
                        'to_city_id' => $booking->trip->to_city_id ?? null,
                        'to_city' => $booking->trip->to_city->name ?? null,
                        'destination_from_id' => $booking->destenation_from,
                        'destination_from_name' => $booking->destnationFrom->name ?? null,
                        'destination_to_id' => $booking->destenation_to,
                        'destination_to_name' => $booking->destnationTo->name ?? null,
                        'deputre_time' => $booking->trip->deputre_time ?? null,
                        'arrival_time' => $booking->trip->arrival_time ?? null,
                        'date' => $booking->date,
                        'seats_count' => $booking->seats_count,
                        'status' => $booking->status,
                        'booking_users' => $booking->bookingUsers->map(function ($passenger) {
                            return [
                                'id' => $passenger->id,
                                'name' => $passenger->name,
                                'age' => $passenger->age,
                                'user_id' => $passenger->user_id,
                                'user_name' => $passenger->user->name ?? null,
                                'user_email' => $passenger->user->email ?? null,
                                'user_phone' => $passenger->user->phone ?? null,
                                'payment_id' => $passenger->payment_id,
                                'booking_id' => $passenger->booking_id,
                                'private_request_id' => $passenger->private_request_id,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json(['data' => $data]);
    }


    public function addUser(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $usercreation = User::create([
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);
        $currancies = Currency::
        get();
        $data = [];
        foreach ($currancies as $item) {
            $this->wallet
            ->create([
                'user_id' => $usercreation->id,
                'currency_id' => $item->id,
                'amount' => 0,
                'total' => 0,
            ]);
        }

        if ($usercreation) {
            return response()->json(['message' => 'User Created Successfully'], 200);
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User Deleted Successfully'], 200);
        }
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $data = [
                'country_id' => $request->country_id ?? $user->country_id,
                'city_id' => $request->city_id ?? $user->city_id,
                'zone_id' => $request->zone_id ?? $user->zone_id,
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'phone' => $request->phone ?? $user->phone,
                'role' => 'user' ?? $user->role
            ];
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }
            $user->update($data);
            return response()->json(['message' => 'User Updated Successfully'], 200);
        }
    }
}
