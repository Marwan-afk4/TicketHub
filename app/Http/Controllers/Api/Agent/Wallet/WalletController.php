<?php

namespace App\Http\Controllers\Api\Agent\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wallet;

class WalletController extends Controller
{
    public function __construct(private Wallet $wallet){}

    public function view(Request $request){
        // /agent/wallet
        $wallets = $this->wallet
        ->where('user_id', $request->user()->id)
        ->with(['currency:id,name'])
        ->get();

        return response()->json([
            'wallets' => $wallets
        ]);
    }
}
