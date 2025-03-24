<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function getUsers()
{
    $users = User::where('role', 'user')
        ->with(['country', 'city', 'zone', 'bookings.bus', 'bookings.trip'])
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
                    'bus_id' => $booking->bus_id,
                    'bus_name' => $booking->bus->bus_number ?? null,
                    'trip_id' => $booking->trip_id,
                    'trip_name' => $booking->trip->trip_name ?? null,
                    'destination_from' => $booking->destenation_from,
                    'destination_to' => $booking->destenation_to,
                    'date' => $booking->date,
                    'seats_count' => $booking->seats_count,
                    'status' => $booking->status
                ];
            })
        ];
    });

    return response()->json(['data' => $data]);
}


    public function addUser(Request $request){
        $validation = Validator::make(request()->all(),[
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
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

        if($usercreation){
            return response()->json(['message'=>'User Created Successfully'],200);
        }

    }

    public function deleteUser($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json(['message'=>'User Deleted Successfully'],200);
        }
    }

    public function UpdateUser(Request $request,$id){
        $user = User::find($id);
        if($user){
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
            return response()->json(['message'=>'User Updated Successfully'],200);
        }
    }
}
