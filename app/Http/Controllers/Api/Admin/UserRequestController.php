<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\UserRequest;

class UserRequestController extends Controller
{
    public function __construct(private UserRequest $user_request){}
    public function view(){
        $user_request = $this->user_request
        ->where('status', 'pending')
        ->get();

        return response()->json([
            'user_request' => $user_request
        ]);
    }
      public function status(Request $request, $id){
        // approve, reject
        $validation = Validator::make(request()->all(),[
            'status' => 'required|in:approve,reject',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $user_request = $this->user_request
        ->where('id', $id)
        ->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => $request->status
        ]);
    }
}
