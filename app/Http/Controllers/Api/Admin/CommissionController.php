<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{

    public function getAgentCommission($id){
        $agent = Commission::where('agent_id', $id)->first();
        return response()->json([
            'commission' => $agent
        ]);
    }

    public function addDefultCommission(Request $request){
        $validation = Validator::make(request()->all(),[
            'train'=>'required',
            'bus'=>'required',
            'hiace'=>'required',
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
    }

        $commission = Commission::create([
            'agent_id'=>null,
            'train' => $request->train,
            'bus' => $request->bus,
            'hiace' => $request->hiace,
            'type'=>'default'
        ]);

        return response()->json(['message'=>'defult commission added successfully']);
    }
}
