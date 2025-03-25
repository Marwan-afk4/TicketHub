<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{


    public function History(){
        $bookingHistory = Booking::where('status', 'confirmed')->get();
        $data =[
            'bookingHistory' => $bookingHistory
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
        return response()->json(['message' => 'Booking Confirmed']);
    }

    public function cancelBook($id){
        $booking = Booking::find($id);
        $booking->status = 'canceled';
        $booking->save();
        return response()->json(['message' => 'Booking Canceled']);
    }
}
