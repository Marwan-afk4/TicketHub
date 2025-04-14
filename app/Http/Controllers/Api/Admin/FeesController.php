<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceFees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeesController extends Controller
{


    public function getFees() {
        $fee = ServiceFees::first();

        if (!$fee) {
            return response()->json(['message' => 'No fees found'], 404);
        }

        $data = [
            'id' => $fee->id,
            'train_fees' => $fee->train,
            'bus_fees' => $fee->bus,
            'hiace_fees' => $fee->hiace,
            'private_request_fees' => $fee->private_request,
        ];

        return response()->json(['fees' => $data]);
    }


    public function addFees(Request $request){
        $validation = Validator::make($request->all(),[
            'train_fees' => 'required|decimal:2',
            'bus_fees' => 'required|decimal:2',
            'hiace_fees' => 'required|decimal:2',
            'private_request_fees' => 'required|decimal:2',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],422);
        }

        $fees = ServiceFees::create([
            'train' => $request->train_fees,
            'bus' => $request->bus_fees,
            'hiace' => $request->hiace_fees,
            'private_request' => $request->private_request_fees,
        ]);

        return response()->json([
            'message' => 'Fees added successfully',
            'fees'=>$fees
        ]);
    }

    public function updateFees(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'train_fees' => 'required|decimal:2',
            'bus_fees' => 'required|decimal:2',
            'hiace_fees' => 'required|decimal:2',
            'private_request_fees' => 'required|decimal:2',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],422);
        }

        $fees = ServiceFees::findOrFail($id)
            ->first();

        $fees->update([
            'train' => $request->train_fees,
            'bus' => $request->bus_fees,
            'hiace' => $request->hiace_fees,
            'private_request' => $request->private_request_fees,
        ]);

        return response()->json([
            'message' => 'Fees updated successfully',
            'fees'=>$fees
        ]);
    }

    public function deleteFees($id){
        $fees = ServiceFees::findOrFail($id);
        $fees->delete();
        return response()->json([
            'message' => 'Fees deleted successfully',
        ]);
    }

}
