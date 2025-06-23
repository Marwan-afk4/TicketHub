<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Image;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\AdminRole;
use App\Models\AdminPosition;

class AdminController extends Controller
{
    use Image;
    public function view()
    {
        $users = User::where('role', 'admin')
            ->with(['position.roles'])
            ->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'position' => $user->position, 
            ];
        });
        $roles = AdminPosition::get();

        return response()->json([
            'data' => $data,
            'roles' => $roles
        ]);
    }


    public function create(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
            'admin_position_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $adminRequest = [ 
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'admin_position_id' => $request->admin_position_id,
        ];
        if ($request->image) {
            $image_path = $this->upload_image($request, 'image', 'admin/images');
            $adminRequest['image_path'] = $image_path;
        }
        $usercreation = User::create($adminRequest);

        if ($usercreation) {
            return response()->json(['message' => 'Admin Created Successfully'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'admin_position_id' => 'required',
        ]);
        $admin = User::find($id);
        $adminRequest = [ 
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'admin_position_id' => $request->admin_position_id
        ];
        if ($admin) {
            if (!empty($request->password)) {
                $adminRequest['password'] = Hash::make($request->password);
            }
            if (!empty($request->image) && !is_string($request->image)) {
                $image_path = $this->update_image($request, $admin->image, 'image', 'admin/images');
                $adminRequest['image_path'] = $image_path;
            }
            $admin->update($data);
            return response()->json(['message' => 'Admin Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Admin not fouund'], 400);
    }

    public function delete($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json(['message' => 'Admin Deleted Successfully'], 200);
        }
        return response()->json(['message' => 'Admin not fouund'], 400);
    }
}
