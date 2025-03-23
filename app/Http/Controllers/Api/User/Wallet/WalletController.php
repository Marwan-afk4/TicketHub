<?php

namespace App\Http\Controllers\Api\User\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Wallet;

class WalletController extends Controller
{
    public function __construct(private Wallet $wallets){}

    public function view(Request $request){
        // /user/wallet
        $wallets = $this->wallets
        ->with('currency:id,name,symbol')
        ->where('user_id', $request->user()->id)
        ->get();

        return response()->json([
            'wallets' => $wallets
        ]);
    }

    public function charge(Request $request){
        // /user/wallet/charge
        // Keys
        // wallet_id, amount
        $validation = Validator::make($request->all(),[
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric'
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $this->wallets
        ->where('id', $request->wallet_id)
        ->update([
            'amount' => $request->amount,
        ]);

        return response()->json([
            'success' => 'You charge success'
        ]);
    }
}
