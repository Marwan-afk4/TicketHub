<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayoutController extends Controller
{


    public function cancelPayout(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'rejected_reason'=>'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors());
        }
        $payout = PayoutRequest::find($id);
        $payout->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason
        ]);
        return response()->json(['message' => 'Payout request has been rejected'], 200);
    }
}
