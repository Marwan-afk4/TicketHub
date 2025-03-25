<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrancyController extends Controller
{

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
            $currancy->delete();
            return response()->json(['message'=>'Currancy Deleted Successfully'],200);
        }
    }
}
