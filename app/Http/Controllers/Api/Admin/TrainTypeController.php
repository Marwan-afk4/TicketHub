<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainTypeController extends Controller
{


    public function getTypes(){
        $trainType = TrainType::all();
        $data = [
            'trainTypes' => $trainType
        ];
        return response()->json($data);
    }

    public function addType(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:train_types,name'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $trainType = TrainType::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => 'You add train type success'
        ]);
    }

    public function updateType(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'name' => ['nullable', 'string', 'unique:train_types,name,'.$id],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $trainType = TrainType::find($id);
        $trainType->update([
            'name' => $request->name??$trainType->name
        ]);

        return response()->json([
            'success' => 'You update train type success'
        ]);
    }

    public function deleteType($id){
        $trainType = TrainType::find($id);
        $trainType->delete();
        return response()->json([
            'success' => 'You delete train type success'
        ]);
    }
}
