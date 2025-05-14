<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Payment;

class BookingController extends Controller
{


    public function History()
{
//     $users = User::where('role', 'user')
//         ->whereHas('bookings', function ($query) {
//             $query->where('status', 'confirmed');
//         })
//         ->with([
//             'country', 'city', 'zone',
//             'bookings' => function ($query) {
//                 $query->where('status', 'confirmed');
//             },
//             'bookings.agent',
//             'bookings.bus',
//             'bookings.trip.country',
//             'bookings.trip.city',
//             'bookings.trip.to_country',
//             'bookings.trip.to_city',
//             'bookings.destnationFrom',
//             'bookings.destnationTo',
//             'bookings.bookingUsers.user'
//         ])
//         ->get();

//     $data = $users->map(function ($user) {
//         return [
//             'bookings' => $user->bookings->map(function ($booking) {
//                 return [
//                     'user_id' => $booking->user_id,
//                     'agent_id' => $booking->agent_id,
//                     'agent_name' => $booking->agent->name ?? null,
//                     'agent_email' => $booking->agent->email ?? null,
//                     'agent_phone' => $booking->agent->phone ?? null,
//                     'agent_code'=> $booking->agent->code ?? null,
//                     'bus_id' => $booking->bus_id,
//                     'bus_name' => $booking->bus->bus_number ?? null,
//                     'trip_id' => $booking->trip_id,
//                     'trip_name' => $booking->trip->trip_name ?? null,
//                     'country_residence_id' => $booking->trip->country_id ?? null,
//                     'country_residence' => $booking->trip->country->name ?? null,
//                     'city_residence_id' => $booking->trip->city_id ?? null,
//                     'city_residence' => $booking->trip->city->name ?? null,
//                     'to_country_id' => $booking->trip->to_country_id ?? null,
//                     'to_country' => $booking->trip->to_country->name ?? null,
//                     'to_city_id' => $booking->trip->to_city_id ?? null,
//                     'to_city' => $booking->trip->to_city->name ?? null,
//                     'destination_from_id' => $booking->destenation_from,
//                     'destination_from_name' => $booking->destnationFrom->name ?? null,
//                     'destination_to_id' => $booking->destenation_to,
//                     'destination_to_name' => $booking->destnationTo->name ?? null,
//                     'deputre_time' => $booking->trip->deputre_time ?? null,
//                     'arrival_time' => $booking->trip->arrival_time ?? null,
//                     'date' => $booking->date,
//                     'seats_count' => $booking->seats_count,
//                     'status' => $booking->status,
//                     'booking_users' => $booking->bookingUsers->map(function ($passenger) {
//                         return [
//                             'id' => $passenger->id,
//                             'name' => $passenger->name,
//                             'age' => $passenger->age,
//                             'user_id' => $passenger->user_id,
//                             'user_name' => $passenger->user->name ?? null,
//                             'user_email' => $passenger->user->email ?? null,
//                             'user_phone' => $passenger->user->phone ?? null,
//                             'payment_id' => $passenger->payment_id,
//                             'booking_id' => $passenger->booking_id,
//                             'private_request_id' => $passenger->private_request_id,
//                         ];
//                     }),
//                 ];
//             }),
//         ];
//     });

//     return response()->json(['userBookings' => $data]);
//
    $bookings = Booking::with([
        'user',
        'agent',
        'bus',
        'trip.country',
        'trip.city',
        'trip.to_country',
        'trip.to_city',
        'destnationFrom',
        'destnationTo',
        'bookingUsers.user'
    ])->get();

    $data =[
        'bookings'=>$bookings
    ];
    return response()->json($data);
    }



    public function canceled(){
        $bookingCanceled = Booking::where('status', 'canceled')->get();
        $data =[
            'bookingCanceled' => $bookingCanceled
        ];
        return response()->json($data);
    }

    public function Upcoming(){
        $bookingUpcoming = Booking::where('status', 'pending')->get();
        $data =[
            'bookingpending' => $bookingUpcoming
        ];
        return response()->json($data);
    }

    public function confirmBook($id){
        $booking = Booking::find($id);
        $booking->status = 'confirmed';
        $booking->save();
        Payment::where('booking_id', $id)
        ->update(['status', 'confirmed']);
        return response()->json(['message' => 'Booking Confirmed']);
    }

    public function cancelBook($id){
        $booking = Booking::find($id);
        $booking->status = 'canceled';
        $booking->save();
        return response()->json(['message' => 'Booking Canceled']);
    }
}
