<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;

class CurrancyController extends Controller
{
    public function __construct(private User $user, private Wallet $wallet){}

    public function getCurrincies(){
        $currancies = Currency::all();
        $data =[
            'currancies' => $currancies
        ];
        return response()->json($data);
    }

    public function addCurrancy(Request $request){
        $validation = Validator::make(request()->all(), [
            'name' => 'required',
            'symbol' => 'required',
            'status' => 'required|in:1,0',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }
        $currancy = Currency::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'status' => $request->status ?? 1,
        ]);
        $users = $this->user
        ->where('role', 'agent')
        ->orWhere('role', 'user')
        ->get();
        $data = [];
        foreach ($users as $item) {
            $data[] = [
                'user_id' => $item->id,
                'currency_id' => $currancy->id,
                'amount' => 0,
                'total' => 0,
            ];
        }
        $this->wallet
        ->createMany($data);

        return response()->json([
            'message' => 'Currancy added successfully',
        ]);
    }

    public function updateCurrancy(Request $request,$id){
        $validation = Validator::make(request()->all(), [
            'name' => 'required',
            'symbol' => 'required',
            'status' => 'required|in:1,0',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }
        $currancy = Currency::find($id);
        if($currancy){
            $currancy->update([
                'name' => $request->name ?? $currancy->name,
                'symbol' => $request->symbol ?? $currancy->symbol,
                'status' => $request->status ?? $currancy->status,
            ]);
            return response()->json([
                'message' => 'Currancy updated successfully',
            ]);
        }
    }

    public function deleteCurrancy($id){
        $currancy = Currency::find($id);
        if($currancy){
            $this->wallet
            ->where('currency_id', $id)
            ->delete();
            $currancy->delete();
            return response()->json(['message'=>'Currancy Deleted Successfully'],200);
        }
    }
}
