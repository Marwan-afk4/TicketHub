<?php

namespace App\Http\Controllers\Api\Agent\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(
        private Payment $payments){}

    public function view(Request $request){
        $payments = $this->payments
        ->with(['trip.', 'travellers'])
        ->where('agent_id', $request->user()->id)
        ->get();
    }
}
