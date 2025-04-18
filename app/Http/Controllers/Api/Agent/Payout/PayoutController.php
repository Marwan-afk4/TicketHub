<?php

namespace App\Http\Controllers\Api\Agent\Payout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\PayoutRequest;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\OperatorPaymentMethod;

class PayoutController extends Controller
{
    public function __construct(private PayoutRequest $payout,
    private Wallet $wallet, private Currency $currency
    , private OperatorPaymentMethod $payment_methods){}

    public function history(Request $request){
        // /agent/payout
        $payout_history = $this->payout
        ->where('agent_id', $request->user()->id)
        ->with(['currency:id,name'])
        ->get();
        $currency = $this->currency
        ->get();
        $payment_methods = $this->payment_methods
        ->where('status', 'active')
        ->get();

        return response()->json([
            'payout_history' => $payout_history,
            'currency' => $currency,
            'payment_methods' => $payment_methods,
        ]);
    }

    public function payout_request(Request $request){
        // /agent/payout/request
        // Keys
        // currency_id, amount, payment_method_id, description
        $validation = Validator::make(request()->all(),[ 
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric', 
            'payment_method_id' => 'required|exists:operator_payment_methods,id', 
            'description' => 'required', 
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $wallet = $this->wallet
        ->where('user_id', $request->user()->id)
        ->where('currency_id', $request->currency_id)
        ->first();
        if (empty($wallet)) {
            return response()->json([
                'errors' => "You don't have money at this wallet you can change currency"
            ], 400);
        }
        if ($wallet->amount < $request->amount) {
            return response()->json([
                'errors' => "You don't have money enough at this wallet you can change currency"
            ], 400);
        }
        $this->payout
        ->create([
            'agent_id' => $request->user()->id,
            'currency_id' => $request->currency_id,
            'amount' => $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'description' => $request->description,
            'date' => date('Y-m-d'),
        ]);

        return response()->json([
            'success' => 'You make payout request'
        ]);
    }
}
