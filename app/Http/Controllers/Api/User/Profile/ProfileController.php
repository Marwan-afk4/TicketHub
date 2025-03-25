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
        // bcknd.ticket-hub.net/user/profile
        $user = $request->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request){
        // bcknd.ticket-hub.net/user/profile/update
        // Keys
        // nationality_id, name, email, phone, gender, password, image
        $validation = Validator::make($request->all(),[
            'nationality_id' => ['exists:nationalities,id'],
            'name' => ['string'],
            'email' => ['email', Rule::unique('users')->ignore($request->user()->id)],
            'phone' => [Rule::unique('users')->ignore($request->user()->id)],
            'gender' => ['in:male,female'],
            'password' => ['min:8'],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $profileRequest = $validation->validated();
        $profileRequest['password'] = Hash::make($request->password);
        $user = $this->users
        ->where('id', $request->user()->id)
        ->first();
        if ($request->image && !is_string($request->image)) {
            $image_path = $this->update_image($request, $user->image ,'image', '/users/image');
        }
        $user->nationality_id = $request->nationality_id ?? $user->nationality_id;
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;
        $user->gender = $request->gender ?? $user->gender;
        $user->password = $request->password && !empty($request->password) ?
        $request->password : $user->password;
        $user->image = isset($image_path) ? $image_path : $user->image;
        $user->save();

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
