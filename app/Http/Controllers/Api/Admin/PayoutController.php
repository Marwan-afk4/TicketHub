<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayoutController extends Controller
{


    public function getPayoutRequest(){
        $payout = PayoutRequest::where('status', 'pending')
        ->with(['currency:id,name,symbol','payment_method:id,name,image','agent:id,name,email,phone,image'])->get();
        $data =[
            'payout' => $payout
        ];
        return response()->json($data);
    }

    public function cancelPayout(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'rejected_reason'=>'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors());
        }
        $payout = PayoutRequest::find($id);
        $payout->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason
        ]);
        return response()->json(['message' => 'Payout request has been rejected'], 200);
    }

    public function confirmPayout(Request $request, $id){
        $payout = PayoutRequest::find($id);
        $agent_id = $payout->agent_id;
        $wallet = Wallet::where('user_id', $agent_id)->where('currency_id', $payout->currency_id)->first();
        // dd($wallet->amount);
        if($wallet->amount < $payout->amount){
            return response()->json(['message' => 'Insufficient balance your wallet ballance is'. ' ' .$wallet->amount], 400);
        }
        elseif($wallet->amount == $payout->amount || $wallet->amount > $payout->amount){
            $wallet->update([
                'amount' => $wallet->amount - $payout->amount,
                'total' => $wallet->total - $payout->amount
            ]);
        }
        $payout->update([
            'status' => 'approved'
        ]);
        return response()->json(['message' => 'Payout request has been confirmed'], 200);

    }
}
