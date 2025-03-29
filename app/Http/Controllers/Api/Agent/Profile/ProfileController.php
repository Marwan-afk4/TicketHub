<?php

namespace App\Http\Controllers\Api\Agent\Profile;

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
        // bcknd.ticket-hub.net/agent/profile
        $agent = $request->user();

        return response()->json([
            'agent' => $agent
        ]);
    }
    // train, private request, booking, trips, wallet, payout, reports
    public function update(Request $request){
        // bcknd.ticket-hub.net/agent/profile/update
        // Keys
        // name, email, phone, password, image
        $validation = Validator::make($request->all(),[
            'name' => ['string'],
            'email' => ['email', Rule::unique('users')->ignore($request->user()->id)],
            'phone' => [Rule::unique('users')->ignore($request->user()->id)],
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
            $image_path = $this->update_image($request, $user->image ,'image', '/agent/image');
        }
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;
        $user->password = $request->password && !empty($request->password) ?
        $request->password : $user->password;
        $user->image = isset($image_path) ? $image_path : $user->image;
        $user->save();

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
