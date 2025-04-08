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
        // /agent/payments
        $payments = $this->payments
        ->with(['trip' => function($query){
            $query->with('city', 'to_city');
        }, 'travellers', 'currency', 'travellers'])
        ->where('agent_id', $request->user()->id)
        ->get()
        ->map(function($item){
            return [
                'id' => $item->id,
                'code' => $item?->booking?->code,
                'transaction_date' => $item->created_at->format('Y-m-d'),
                'deputre_date' => $item->travel_date . ' ' . $item?->trip?->deputre_time,
                'arrival_date' => $item->travel_date . ' ' . $item?->trip?->arrival_time,
                'route' => [
                    'from' => $item?->trip?->pickup_station?->name . ' ' . $item?->trip?->city?->name,
                    'to' => $item?->trip?->dropoff_station?->name . ' ' . $item?->trip?->to_city?->name,
                ],
                'status' => $item?->booking?->status ?? 'pending',
                'passengers' => $item?->travellers,
                'tickets' => $item->travelers,
                'total_cost' => $item->total,
                'currency' => $item->currency->name,
            ];
        });
        $total = $payments->sum('total_cost');

        return response()->json([
            'payments' => $payments,
            'total' => $total,
        ]);
    }
}
