<?php

namespace App\Http\Controllers\Api\Agent\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

class EarningReportController extends Controller
{
    public function __construct(private Payment $payments){}

    public function view(Request $request){
        // /agent/report/earning
        $earning = $this->payments
        ->select('id', 'amount', 'total', 'status', 'commission')
        ->where('agent_id', $request->user()->id)
        ->where('status', 'confirmed')
        ->get()
        ->map(function($item){
            $item->travel_status = $item?->booking?->status ?? null;
            $item->makeHidden(['booking', 'booking_id']);
            return $item;
        });
        $total = $earning->sum('total');
        $total_operator = $earning->sum('operator');

        return response()->json([
            'earning' => $earning,
            'total' => $total,
            'total_operator' => $total_operator,
        ]);
    }
}
