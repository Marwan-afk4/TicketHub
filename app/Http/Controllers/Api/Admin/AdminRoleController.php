<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\AdminRole;
use App\Models\AdminPosition;

class AdminRoleController extends Controller
{
    public function __construct(private AdminPosition $admin_position,
    private AdminRole $admin_role){}

    public function view(){
        $admin_position = $this->admin_position
        ->with('roles')
        ->get();
        $modules = [
            'payment_methods', 'admin', 'admin_role', 'wallet_request', 'user_request', 
            'redeem_point', 'point', 'countries', 'cities', 'zones', 'stations', 'hiaces',
            'complaints', 'complaint_subject', 'currencies', 'nationalities', 
            'operators', 'booking', 'bus', 'bus_types',
            'payment', 'aminites', 'trip_request', 'private_request', 'trips', 'car_categories',
            'car_brands', 'car_models', 'cars', 'trainTypes', 'trainclasses', 'trainRoutes', 'trains',
            'Commission', 'operator_payment_methods', 'payoutRequest', 'fees', 'user'
        ];
        $actions = [
            'view',
            'status',
            'add',
            'edit',
            'delete',
        ];

        return response()->json([
            'admin_position' => $admin_position,
            'modules' => $modules,
            'actions' => $actions,
        ]);
    }

    public function create(Request $request){
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
            'roles' => 'array|required',
            'roles.*.module' => 'required',
            'roles.*.action' => 'required|array',
            'roles.*.action.*' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $admin_position = $this->admin_position
        ->create([
            'name' => $request->name
        ]); 
        foreach ($request->roles as $role) {
            foreach ($role['action'] as $action) {
                $this->admin_role
                ->create([
                    'admin_position_id' => $admin_position->id,
                    'module' => $role['module'],
                    'action' => $action,
                ]);
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
            'roles' => 'array|required',
            'roles.*.action.*' => 'required',
            'roles.*.module.*' => 'required',
            'roles.*.action' => 'required|array',
            'roles.*.action.*' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $admin_position = $this->admin_position
        ->where('id', $id)
        ->first();
        if (empty($admin_position)) {
            return response()->json([
                'errors' => 'Admin role not found'
            ], 400);
        }
        $admin_position->update([
            'name' => $request->name
        ]);
        $this->admin_role
        ->where('admin_position_id', $id)
        ->delete();
        foreach ($request->roles as $role) {
            foreach ($role['action'] as $action) {
                $this->admin_role
                ->create([
                    'admin_position_id' => $admin_position->id,
                    'module' => $role['module'],
                    'action' => $action,
                ]);
            }
        }

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $admin_position = $this->admin_position
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
