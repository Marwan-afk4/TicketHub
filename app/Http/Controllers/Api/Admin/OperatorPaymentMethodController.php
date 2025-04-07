<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\OperatorPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperatorPaymentMethodController extends Controller
{
    use Image;

    public function getOperatorPaymentMetod(){
        $paymentMethod = OperatorPaymentMethod::all();
        $data = [
            'paymentMethod' => $paymentMethod
        ];
        return response()->json($data);
    }

    public function addOperatorPaymentMethod(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|unique:operator_payment_methods,name',
            'image'=>'required|string',
            'status'=>'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors());
        }

        $paymentMethod = OperatorPaymentMethod::create([
            'name'=>$request->name,
            'image'=>$this->storeBase64Image($request->image , 'admin/payment_method/operator'),
            'status'=>$request->status
        ]);

        $data = [
            'message' => 'Operator Payment Method Created Successfully',
            'paymentMethod' => $paymentMethod
        ];
        return response()->json($data);
    }

    public function updateOperatorPaymentMethod(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'name'=>'nullable|string|unique:operator_payment_methods,name,'.$id,
            'image'=>'nullable|string',
            'status'=>'nullable|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors());
        }

        $paymentMethod = OperatorPaymentMethod::find($id);
        $paymentMethod->name = $request->name ?? $paymentMethod->name;
        $paymentMethod->status = $request->status ?? $paymentMethod->status;
        if($request->image){
            $paymentMethod->image = $this->storeBase64Image($request->image , 'admin/payment_method/operator');
        }
        $paymentMethod->save();

        return response()->json([
            'message' => 'Operator Payment Method Updated Successfully',
            'paymentMethod' => $paymentMethod
        ]);
    }

    public function deleteOperatorPaymentMethod($id){
        $paymentMethod = OperatorPaymentMethod::find($id);
        $paymentMethod->delete();
        return response()->json([
            'message' => 'Operator Payment Method Deleted Successfully'
        ]);
    }

}
