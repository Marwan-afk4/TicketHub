<?php

namespace App\Http\Controllers\Api\User\Points;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Point;
use App\Models\Wallet;
use App\Models\User;

class PointsController extends Controller
{
    public function __construct(
        private Point $points,
        private Wallet $wallet,
        private User $user,
    ){}

    public function view(Request $request){
        $user_data = $request->user();
        $redeem_points = $this->points
        ->with('currency')
        ->get();

        return response()->json([
            'user_data' => $user_data,
            'redeem_points' => $redeem_points,
        ]);
    }

    public function convert(Request $request){
        $validation = Validator::make(request()->all(),[ 
            'currency_id' => ['exists:currencies,id', 'required'],
            'points' => ['numeric', 'required', 'gt:' . $request->user()->points],
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $redeem_points = $this->points
        ->where('currency_id', $request->currency_id)
        ->first();
        if (empty($redeem_points)) {
            return response()->json([
                'errors' => "You can't redeem point now"
            ], 400);
        }
        $points = $request->points - $request->points % $redeem_points->points;
        $redeem_point = $points / $redeem_points->points;
        $wallet = $this->wallet
        ->where('currency_id', $request->currency_id)
        ->where('user_id', $request->user()->id)
        ->first();
        $wallet->amount = $wallet->amount + $redeem_point;
        $wallet->save();
        $user = $this->user
        ->where('id', $request->user()->id)
        ->first();
        $user->points -= $points;
        $user->save();

        return response()->json([
            'success' => 'You change points success'
        ]);
    }
}
