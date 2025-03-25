<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
    use Image;

    public function getOperators()
{
    $operators = User::where('role', 'agent')->get();

    $data = $operators->map(fn($operator) => [
        'id' => $operator->id,
        'name' => $operator->name,
        'email' => $operator->email,
        'phone' => $operator->phone,
        'image' => $operator->image ? asset('storage/' . $operator->image) : null,
        'points' => $operator->points,
        'role' => $operator->role,
        'code' => $operator->code,
    ]);

    return response()->json([ 'operators' => $data]);
}

public function addOperator(Request $request)
{
    $validation = Validator::make($request->all(), [
        'name' => ['required', 'string'],
        'email' => ['required', 'email', 'unique:users,email'],
        'phone' => ['required', 'unique:users,phone'],
        'password' => ['required', 'min:8'],
        'image' => ['nullable', 'string'], // Ensure valid base64 image handling
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
    ]);

    return response()->json(['message' => 'Operator added successfully']);
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
    ]);

    if ($validation->fails()) {
        return response()->json(['message' => $validation->errors()], 400);
    }

    $operator = User::find($id);

    if (!$operator) {
        return response()->json(['message' => 'Operator not found'], 404);
    }

    $operator->update([
        'name' => $request->name ?? $operator->name,
        'email' => $request->email ?? $operator->email,
        'phone' => $request->phone ?? $operator->phone,
        'image' => $request->image ? $this->storeBase64Image($request->image, 'admin/operator') : $operator->image,
    ]);

    return response()->json(['message' => 'Operator updated successfully']);
}


}
