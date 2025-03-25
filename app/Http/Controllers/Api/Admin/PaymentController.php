<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function pendintPayment(){
        $pendintPayment = Payment::where('status', 'pending')->get();
        $data =[
            'pendintPayment' => $pendintPayment
        ];
        return response()->json($data);
    }

    public function confirmedPayment(){
        $confirmedPayment = Payment::where('status', 'confirmed')->get();
        $data =[
            'confirmedPayment' => $confirmedPayment
        ];
        return response()->json($data);
    }

    public function canceledPayment(){
        $canceledPayment = Payment::where('status', 'canceled')->get();
        $data =[
            'canceledPayment' => $canceledPayment
        ];
        return response()->json($data);
    }
}
