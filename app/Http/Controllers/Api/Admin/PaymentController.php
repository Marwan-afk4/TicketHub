<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingUser;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function pendintPayment(){
        $pendintPayment = Payment::where('status', 'pending')->get()
        ->map(function($item){
            $item->receipt_image = url('storage/' . $item->receipt_image);
            return $item;
        });
        $data =[
            'pendintPayment' => $pendintPayment
        ];
        return response()->json($data);
    }

    public function confirmedPayment(){
        $confirmedPayment = Payment::where('status', 'confirmed')->get()
        ->map(function($item){
            $item->receipt_image = url('storage/' . $item->receipt_image);
            return $item;
        });
        $data =[
            'confirmedPayment' => $confirmedPayment
        ];
        return response()->json($data);
    }

    public function canceledPayment(){
        $canceledPayment = Payment::where('status', 'canceled')->get()
        ->map(function($item){
            $item->receipt_image = url('storage/' . $item->receipt_image);
            return $item;
        });
        $data =[
            'canceledPayment' => $canceledPayment
        ];
        return response()->json($data);
    }

    public function confirmPayment($id){
        $payment = Payment::find($id);
        $payment->status = 'confirmed';
        $booking = Booking::create([
            'user_id' => $payment->user_id,
            'trip_id'=> $payment->trip_id,
            'agent_id'=> $payment->agent_id,
            'status' => 'confirmed',
            'seats_count'=>$payment->travelers,
            'bus_id'=>$payment->trip->bus_id,
            'date'=>$payment->trip->date,
            'destenation_from'=>$payment->trip->pickup_station_id,
            'destenation_to'=>$payment->trip->dropoff_station_id,
            'train_id'=>$payment->trip->train_id ?? null
        ]);
        $bookingUser = BookingUser::where('payment_id', $payment->id)
        ->update([
            'booking_id' => $booking->id
        ]);
        $payment->save();
        return response()->json(['message' => 'Payment Confirmed successffully']);
    }

    public function cancelPayment($id){
        $payment = Payment::find($id);
        $payment->status = 'canceled';
        $payment->save();
        return response()->json(['message' => 'Payment Canceled successffully']);
    }
}
