<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    use Image;

    public function getPaymentMethod(){
        $paymob = PaymentMethod::
        where('id', 1)
        ->first();
        if (empty($paymob)) {
            PaymentMethod::create([
                'id' => 1,
                'name' => 'Visa Card',
                'image' => 'visa.webp',
                'status' => 'active',
            ]);
        }
        $paymentMethod = PaymentMethod::all();
        $data =$paymentMethod->map(function($paymentMethod){
            return [
                'id'=> $paymentMethod->id,
                'name' => $paymentMethod->name,
                'image' => url('storage/'.$paymentMethod->image) ?? null,
                'status' => $paymentMethod->status
            ];
        });
        return response()->json($data);
    }

    public function addPaymentMethod(Request $request){
        $validation = Validator::make(request()->all(),[
            'name' => 'required|string',
            'image' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'image' => $this->storeBase64Image($request->image , 'admin/payment_method'),
            'status' => $request->status,
        ]);
    }

    public function updatePaymentMethod(Request $request, $id){
        $paymentMethod = PaymentMethod::find($id);
        if(!$paymentMethod){
            return response()->json(['message'=>'payment method not found']);
        }

        $validation = Validator::make(request()->all(),[
            'name' => 'required|string', 
            'status' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $paymentRequest = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        if ($request->image) { 
            $paymentRequest['image'] = $this->storeBase64Image($request->image , 'admin/payment_method');
        }
        $paymentMethod->update($paymentRequest);
    }

    public function deletepaymentMethod($id){
        $paymentMethod = PaymentMethod::find($id);
        if(!$paymentMethod){
            return response()->json(['message'=>'payment method not found']);
        }
        $paymentMethod->delete();
        return response()->json(['message'=>'payment method deleted successfully']);
    }
}
