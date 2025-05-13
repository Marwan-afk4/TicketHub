<?php

namespace App\Http\Controllers\Api\User\UserRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserRequest;

class UserRequestController extends Controller
{
    public function __construct(private UserRequest $user_request){}

    public function user_request_agent(Request $request){
        $validation = Validator::make(request()->all(),[ 
            'name' => 'required',
            'phone' => 'required|unique:user_requests,phone',
            'email' => 'required|unique:user_requests,email|email',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $this->user_request
        ->create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => 'You add request succes'
        ]);
    }
}
