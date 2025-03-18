<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\Auth\SignupUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{ 
    public function Register(SignupUserRequest $request){
        // /api/register
        // keys
        // password, email, nationality_id, name, phone, gender => [male,female],
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'message'=>'user Added Successfully',
            'user' => $user
        ]);
    }

    public function login(Request $request){
        // /api/login
        // keys
        // password,email
        $validation = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user=User::where('email', $request->email)
        ->orWhere('phone', $request->email)
        ->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=>'Login Successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
