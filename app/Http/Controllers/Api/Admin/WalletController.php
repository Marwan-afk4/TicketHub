<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ChargeWallet;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function __construct(private ChargeWallet $wallet,
    private Wallet $wallet_user){}

    public function view(){
        $wallet = $this->wallet
        ->with('currency', 'user', 'payment_method')
        ->where('status', 'pending')
        ->get();

        return response()->json([
            'wallet' => $wallet
        ]);
    }

    public function status(Request $request, $id){
        $validation = Validator::make(request()->all(),[
            'status' => 'required|in:confirmed,rejected',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $wallet_request = $this->wallet
        ->where('id', $id)
        ->first();
        if ($request->status == 'confirmed') {
            $wallet_user = $this->wallet_user
            ->where('user_id', $wallet_request->user_id)
            ->where('currency_id', $wallet_request->currency_id)
            ->first();
            if (empty($wallet_user)) {
                $wallet_user = $this->wallet_user
                ->create([
                    'user_id' => $wallet_request->user_id,
                    'currency_id' => $wallet_request->currency_id,
                    'amount' =>  $wallet_request->amount,
                    'total' =>  $wallet_request->amount,
                ]);
            }
            else{
                $wallet_user
                ->update([
                    'amount' => $wallet_user->amount + $wallet_request->amount,
                    'total' => $wallet_user->total + $wallet_request->amount,
                ]);
            }
        }
        $wallet_request->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => $request->status
        ]);
    }

}
