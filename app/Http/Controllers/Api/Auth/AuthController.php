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
    public function Register(AuthRequest $request){
        $validated = $request->validated();
        $user = User::create([
            'country_id' => $validated['country_id']??null,
            'city_id' => $validated['city_id']??null,
            'zone_id' => $validated['zone_id']??null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user'
        ]);
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
            'email' => 'required|email',
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
