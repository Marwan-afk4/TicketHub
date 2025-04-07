<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{

    public function getAllCommission()
    {
        $commission = Commission::with('agent')->get();
        $data = $commission->map(function ($commission) {
            return [
                'id' => $commission->id,
                'agent_id' => $commission->agent_id,
                'agent_name' => $commission->agent->name ?? null,
                'agent_email' => $commission->agent->email ?? null,
                'agent_phone' => $commission->agent->phone ?? null,
                'agent_code' => $commission->agent->code ?? null,
                'train' => $commission->train,
                'bus' => $commission->bus,
                'hiace' => $commission->hiace,
            ];
        });

        return response()->json([
            'commission' => $data
        ]);
    }

    public function getDefaultCommission()
    {
        $commission = Commission::where('type', 'defult')->first();

        if (empty($commission)) {
            return response()->json([
                'message' => 'Commission not found'
            ], 400);
        }

        $data = [
            'id' => $commission->id,
            'train' => $commission->train,
            'bus' => $commission->bus,
            'hiace' => $commission->hiace,
        ];

        return response()->json([
            'default_commission' => $data
        ]);
    }

    public function updateDefaultCommission(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'train' => 'required',
            'bus' => 'required',
            'hiace' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $commission = Commission::where('type', 'defult')->first();
        $commission->update([
            'train' => $request->train ?? $commission->train,
            'bus' => $request->bus ?? $commission->bus,
            'hiace' => $request->hiace ?? $commission->hiace,
        ]);

        return response()->json(['message' => 'defult commission updated successfully']);
    }


    public function getAgentCommission($id)
    {
        $agent = Commission::where('agent_id', $id)->first();
        return response()->json([
            'commission' => $agent
        ]);
    }

    public function addDefultCommission(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'train' => 'required',
            'bus' => 'required',
            'hiace' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $commission = Commission::create([
            'agent_id' => null,
            'train' => $request->train,
            'bus' => $request->bus,
            'hiace' => $request->hiace,
            'type' => 'default'
        ]);

        return response()->json(['message' => 'defult commission added successfully']);
    }

    public function addAgentCommission(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'agent_id' => 'required|exists:users,id',
            'train' => 'required',
            'bus' => 'required',
            'hiace' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()], 400);
        }

        $commission = Commission::create([
            'agent_id' => $request->agent_id,
            'train' => $request->train,
            'bus' => $request->bus,
            'hiace' => $request->hiace,
            'type' => 'private'
        ]);

        return response()->json(['message' => 'agent commission added successfully']);
    }
}
