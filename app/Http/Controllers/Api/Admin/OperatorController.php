<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\AgentModule;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
    use Image;

    public function getOperators()
    {
        $operators = User::where('role', 'agent')
        ->with(['modules','commissions'])
        ->get();

        $data = $operators->map(fn($operator) => [
            'id' => $operator->id,
            'name' => $operator->name,
            'email' => $operator->email,
            'phone' => $operator->phone,
            'image' => $operator->image ? asset('storage/' . $operator->image) : null,
            'points' => $operator->points,
            'role' => $operator->role,
            'code' => $operator->code,
            'description' => $operator->description,
            'modules' => $operator->modules->map(fn($module) =>[
                'id' => $module->id,
                'module' => $module->module,
            ]),
            'commissions' => $operator->commissions->map(fn($commission) => [
                'id' => $commission->id,
                'train' => $commission->train,
                'bus' => $commission->bus,
                'hiace' => $commission->hiace,
                'privateRequest' => $commission->private_request,
                'type' => $commission->type
            ])->toArray(),
        ]);

        return response()->json(['operators' => $data]);
    }

    public function addOperator(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'password' => ['required', 'min:8'],
            'image' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'train_commission' => ['nullable', 'numeric'],
            'bus_commission' => ['nullable', 'numeric'],
            'hiace_commission' => ['nullable', 'numeric'],
            'privateRequest_commission' =>['required','numeric'],
            'commission_type' => ['required', 'in:private,defult'],
            'bus_modules' => ['required', 'in:0,1'],
            'train_modules' => ['required', 'in:0,1'],
            'hiace_modules' => ['required', 'in:0,1'],
            'private_modules'=>['required', 'in:0,1'],
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $operator = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/operator') : null,
            'code' => 'OP' . rand(10000, 99999) . strtolower(Str::random(1)),
            'description' => $request->description
        ]);
        $defaultCommission = DB::table('commissions')->where('type', 'defult')->first();
        if (empty($defaultCommission)) {
            $defaultCommission = DB::table('commissions')->insert([
                'train' => 0,
                'bus' => 0,
                'hiace' => 0,
                'private_request'=> 0,
                'type'=>'defult'
            ]);
        }

        if ($request->bus_modules || $request->train_modules || $request->hiace_modules || $request->private_modules) {
            DB::table('commissions')->insert([
                'agent_id' => $operator->id,
                'train' => $request->train_commission ?? $defaultCommission->train,
                'bus' => $request->bus_commission ?? $defaultCommission->bus,
                'hiace' => $request->hiace_commission ?? $defaultCommission->hiace,
                'private_request'=> $request->privateRequest_commission ?? $defaultCommission->private_request,
                'type' => 'private'
            ]);
        } 


        if ($request->bus_modules == 1) {
            AgentModule::create([
                'agent_id' => $operator->id,
                'module' => 'bus',
            ]);
        }

        if ($request->train_modules == 1) {
            AgentModule::create([
                'agent_id' => $operator->id,
                'module' => 'train',
            ]);
        }

        if ($request->hiace_modules == 1) {
            AgentModule::create([
                'agent_id' => $operator->id,
                'module' => 'hiace',
            ]);
        }

        if ($request->private_modules == 1) {
            AgentModule::create([
                'agent_id' => $operator->id,
                'module' => 'private',
            ]);
        }

        return response()->json(['message' => 'Operator added successfully and commission handled correctly']);
    }


    public function deleteOperator($id)
    {
        $operator = User::find($id);

        if (!$operator) {
            return response()->json(['message' => 'Operator not found'], 404);
        }

        $operator->delete();

        return response()->json(['message' => 'Operator deleted successfully']);
    }

    public function updateOperator(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,' . $id],
            'phone' => ['sometimes', 'required', 'unique:users,phone,' . $id],
            'image' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'train_commission' => ['nullable', 'numeric'],
            'bus_commission' => ['nullable', 'numeric'],
            'hiace_commission' => ['nullable', 'numeric'],
            'privateRequest_commission' => ['nullable', 'numeric'],
            'commission_type' => ['nullable', 'in:private,defult'],
            'bus_modules' => ['nullable', 'in:0,1'],
            'train_modules' => ['nullable', 'in:0,1'],
            'hiace_modules' => ['nullable', 'in:0,1'],
            'private_modules' => ['nullable', 'in:0,1'],
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $operator = User::find($id);

        if (!$operator) {
            return response()->json(['message' => 'Operator not found'], 404);
        }

        // Update basic operator information
        $operator->update([
            'name' => $request->name ?? $operator->name,
            'email' => $request->email ?? $operator->email,
            'phone' => $request->phone ?? $operator->phone,
            'description' => $request->description ?? $operator->description,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/operator') : $operator->image,
        ]);

        // Handle commission updates
        
        $defaultCommission = DB::table('commissions')->where('type', 'defult')->first();
        if (empty($defaultCommission)) {
            $defaultCommission = DB::table('commissions')->insert([
                'train' => 0,
                'bus' => 0,
                'hiace' => 0,
                'private_request'=> 0,
                'type'=>'defult'
            ]);
        }

        if ($request->bus_modules || $request->train_modules || $request->hiace_modules || $request->private_modules) {
            $commission = DB::table('commissions')
            ->where('agent_id', $operator->id)
            ->first();
            if (empty($commission)) {
                $commission->insert([
                    'agent_id' => $operator->id,
                    'train' => $request->train_commission ?? $defaultCommission->train,
                    'bus' => $request->bus_commission ?? $defaultCommission->bus,
                    'hiace' => $request->hiace_commission ?? $defaultCommission->hiace,
                    'private_request'=> $request->privateRequest_commission ?? $defaultCommission->private_request,
                    'type' => 'private'
                ]);
            }
            else{
                $commission->update([
                    'agent_id' => $operator->id,
                    'train' => $request->train_commission ?? $defaultCommission->train,
                    'bus' => $request->bus_commission ?? $defaultCommission->bus,
                    'hiace' => $request->hiace_commission ?? $defaultCommission->hiace,
                    'private_request'=> $request->privateRequest_commission ?? $defaultCommission->private_request,
                    'type' => 'private'
                ]);
            }
        } 
        // if ($request->has('commission_type')) {
        //     $operatorCommission = Commission::where('agent_id', $operator->id)->first();

        //     if ($request->commission_type == 'private') {
        //         $commissionData = [
        //             'agent_id' => $operator->id,
        //             'train' => $request->train_commission,
        //             'bus' => $request->bus_commission,
        //             'hiace' => $request->hiace_commission,
        //             'private_request' => $request->privateRequest_commission,
        //             'type' => 'private'
        //         ];
        //     } else {
        //         $defaultCommission = Commission::where('type', 'defult')->first();
        //         if (!$defaultCommission) {
        //             return response()->json(['message' => 'Default commission not found'], 400);
        //         }

        //         $commissionData = [
        //             'agent_id' => $operator->id,
        //             'train' => $defaultCommission->train,
        //             'bus' => $defaultCommission->bus,
        //             'hiace' => $defaultCommission->hiace,
        //             'private_request' => $defaultCommission->private_request,
        //             'type' => 'defult'
        //         ];
        //     }

            if (!$operatorCommission) {
                Commission::create($commissionData);
            } else {
                $operatorCommission->update($commissionData);
            }
        }

        // Handle module updates
        $moduleTypes = ['bus', 'train', 'hiace', 'private'];

        // Delete existing modules for this agent
        AgentModule::where('agent_id', $operator->id)->delete();

        // Create new modules based on request
        foreach ($moduleTypes as $module) {
            $moduleKey = $module . '_modules';
            if ($request->has($moduleKey) && $request->$moduleKey == 1) {
                AgentModule::create([
                    'agent_id' => $operator->id,
                    'module' => $module,
                ]);
            }
        }

        return response()->json(['message' => 'Operator updated successfully']);
    }
}
