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
        ->select('id', 'amount', 'total', 'status', 
        'commission', 'currency_id')
        ->with(['currency:id,name'])
        ->where('agent_id', $request->user()->id)
        ->where('status', 'confirmed')
        ->get()
        ->map(function($item){
            $item->travel_status = $item?->booking?->status ?? null;
            $item->makeHidden(['booking', 'booking_id']);
            return $item;
        });

        $total = [];
        $total_operator = [];
        foreach ($earning as $item) {
            $currency = $item->currency;
            if (isset($total[$currency?->name])) {
                $total[$currency->name] += $item->total;
                $total_operator[$currency->name] += $item->operator;
            }
            else{
                $total[$currency->name] = $item->total;
                $total_operator[$currency->name] = $item->operator;
            }
        }

        return response()->json([
            'earning' => $earning,
            'total' => $total,
            'total_operator' => $total_operator,
        ]);
    }
}
