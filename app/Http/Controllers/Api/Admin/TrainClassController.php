<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainClassController extends Controller
{


    public function getClasses(){
        $trainClasses = TrainClass::all();
        $data = [
            'trainClasses' => $trainClasses
        ];
        return response()->json($data);
    }

    public function addClass(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:train_classes,name'],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $trainClass = TrainClass::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message'=>'You add train class success'
        ]);
    }

    public function updateClass(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'name' => ['nullable', 'string', 'unique:train_classes,name,'.$id],
        ]);

        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $trainClass = TrainClass::find($id);
        $trainClass->update([
            'name' => $request->name??$trainClass->name
        ]);

        return response()->json([
            'success' => 'You update train class success'
        ]);
    }

    public function deleteClass($id){
        $trainClass = TrainClass::find($id);
        $trainClass->delete();
        return response()->json([
            'success' => 'You delete train class success'
        ]);
    }
}
