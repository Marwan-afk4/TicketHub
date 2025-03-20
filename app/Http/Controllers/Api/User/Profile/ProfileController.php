<?php

namespace App\Http\Controllers\Api\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Image;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct(private User $users){}
    use Image;

    public function view(Request $request){
        // /profile
        $user = $request->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request){
        // /profile/update
        // Keys
        // nationality_id, name, email, phone, gender, password, image
        $validation = Validator::make($request->all(),[
            'nationality_id' => ['required', 'exists:nationalities,id'],
            'name' => ['required', 'string'],
            'email' => ['required','email', Rule::unique('users')->ignore($request->user()->id)],
            'phone' => ['required', Rule::unique('users')->ignore($request->user()->id)],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required','min:8'],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $profileRequest = $validation->validated();
        $profileRequest['password'] = Hash::make($request->password);
        if ($request->image && !is_string($request->image)) {
            $image_path = $this->uploadFile($request->image, '/users/image');
            $profileRequest['image'] = $image_path;
        }

        $user = $this->users
        ->where('id', $request->user()->id)
        ->update($profileRequest);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
