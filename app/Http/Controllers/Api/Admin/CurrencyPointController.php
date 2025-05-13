<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CurrencyPoint;
use App\Models\Currency;

class CurrencyPointController extends Controller
{
    public function __construct(private CurrencyPoint $point,
    private Currency $currency){}

    public function view(){
        $redeem_points = $this->points
        ->with('currency')
        ->get();
        $currencies_ids = $redeem_points->pluck('currency_id');
        $currencies = $this->currency
        ->whereNotIn('id', $currencies_ids)
        ->get();

        return response()->json([
            'redeem_points' => $redeem_points,
            'currencies' => $currencies,
        ]);
    }

    public function item($id){
        $redeem_point = $this->points
        ->where('id', $id)
        ->with('currency')
        ->first();

        return response()->json([
            'redeem_point' => $redeem_points,
        ]);
    }

    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'currency_id'=>'required|exists:currencies,id',
            'points' => 'required|numeric',
            'currencies' => 'required|numeric',
        ]);
        if($validation->fails()){
            return response()->json($validation->errors());
        }
        $pointRequest = $validation->validated();
        $this->point
        ->create($pointRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'currency_id'=>'required|exists:currencies,id',
            'points' => 'required|numeric',
            'currencies' => 'required|numeric',
        ]);
        if($validation->fails()){
            return response()->json($validation->errors());
        }
        $pointRequest = $validation->validated();
        $this->point
        ->where('id', $id)
        ->update($pointRequest);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        $this->point
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
