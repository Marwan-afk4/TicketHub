<?php

namespace App\Http\Controllers\Api\User\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Image;

use App\Models\Wallet;
use App\Models\ChargeWallet;

class WalletController extends Controller
{
    public function __construct(private Wallet $wallets,
    private ChargeWallet $charge_wallet){}
    use Image;

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
        $wallet = $this->wallets
        ->where('id', $request->wallet_id)
        ->first();
        $chargeRequest = [
            'user_id' => $request->user()->id,
            'currency_id' => $wallet->currency_id,
            'wallet_id' => $wallet->id,
            'amount' => $request->amount
        ]; 
        if ($request->image && !is_string($request->image)) {
            $image_path = $this->upload_image($request, 'image', '/users/wallet/charge');
            $chargeRequest['image'] = $image_path;
        }
        $this->charge_wallet 
        ->create($chargeRequest);

        return response()->json([
            'success' => 'You charge success'
        ]);
    }
}
