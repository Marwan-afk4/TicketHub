<?php

namespace App\Http\Controllers\Api\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct(private User $users){}

    public function view(Request $request){
        $user = $request->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request){
        $validation = Validator::make($request->all(),[
            'nationality_id' => ['required', 'exists:nationalities,id'],
            'name' => ['required', 'string'],
            'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', Rule::unique('users')->ignore($user->id)],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required','min:8'],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user = $this->users
        ->where('id', $request->user()->id)
        ->first();

        return response()->json([
            'user' => $user
        ]);
    }
}
