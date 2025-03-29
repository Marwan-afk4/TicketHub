<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\Aminity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmintyController extends Controller
{
    use Image;

    public function getAminites(){
        $aminty = Aminity::all();
        $data =[
            'aminty' => $aminty
        ];
        return response()->json($data);
    }

    public function addAminity(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:aminities,name'],
            'icon'=>['required', 'string'],
            'status'=>['required', 'in:active,inactive'],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $aminty = Aminity::create([
            'name' => $request->name,
            'icon'=>$this->storeBase64Image($request->icon , 'admin/aminity'),
            'status' => $request->status,
        ]);
        return response()->json([
            'success' => 'You add aminty success'
        ]);
    }

    public function updateAminity(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:aminities,name,'.$id],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $aminty = Aminity::find($id);
        if($aminty){
            $aminty->update([
                'name' => $request->name ?? $aminty->name,
                'status' => $request->status ?? $aminty->status,
                'icon' => $request->icon ? $this->storeBase64Image($request->icon, 'admin/aminity') : $aminty->icon,
            ]);
            return response()->json([
                'message' => 'You update aminty success'
            ]);
        }
    }

    public function deleteAminity($id){
        $aminty = Aminity::find($id);
        if($aminty){
            $aminty->delete();
            return response()->json([
                'message' => 'You delete aminty success'
            ]);
        }
    }
}
