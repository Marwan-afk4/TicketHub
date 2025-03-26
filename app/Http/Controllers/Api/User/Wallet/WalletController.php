<?php

namespace App\Http\Controllers\Api\User\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Image;

use App\Models\Wallet;
use App\Models\ChargeWallet;
use App\Models\Currency;
use App\Models\PaymentMethod;

class WalletController extends Controller
{
    public function __construct(private Wallet $wallets,
    private ChargeWallet $charge_wallet, private Currency $currency,
    private PaymentMethod $payment_methods){}
    use Image;

    public function view(Request $request){
        // /user/wallet
        $wallets = $this->wallets
        ->with(['currency:id,name,symbol'])
        ->where('user_id', $request->user()->id)
        ->get(); 

        return response()->json([
            'wallets' => $wallets
        ]);
    }

    public function lists(Request $request){
        // /user/wallet/lists
        $currencies = $this->currency
        ->get();
        $payment_methods = $this->payment_methods
        ->get();

        return response()->json([
            'currencies' => $currencies,
            'payment_methods' => $payment_methods,
        ]);
    }

    public function history(Request $request){
        // /user/wallet/history
        $history = $this->charge_wallet
        ->with(['currency:id,name,symbol', 'payment_method:id,name'])
        ->where('user_id', $request->user()->id)
        ->get();

        return response()->json([
            'history' => $history
        ]);
    }

    public function charge(Request $request){
        // /user/wallet/charge
        // Keys
        // wallet_id, amount, payment_method_id, image
        $validation = Validator::make($request->all(),[
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric',
            'payment_method_id' => 'nullable|exists:payment_methods,id'
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
            'amount' => $request->amount,
            'payment_method_id' => $request->payment_method_id,
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
