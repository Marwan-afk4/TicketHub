<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationailtyController extends Controller
{

    public function getNationalities(){
        $nationalities = Nationality::all();
        $data =[
            'nationalities' => $nationalities
        ];
        return response()->json($data);
    }

    public function addNationality(Request $request){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:nationalities,name'],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $nationality = Nationality::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'success' => 'You add nationality success'
        ]);
    }

    public function updateNationality(Request $request,$id){
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string', 'unique:nationalities,name,'.$id],
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $nationality = Nationality::find($id);
        if($nationality){
            $nationality->update([
                'name' => $request->name ?? $nationality->name,
            ]);
            return response()->json([
                'message' => 'You update nationality success'
            ]);
        }
    }

    public function deleteNationality($id){
        $nationality = Nationality::find($id);
        if($nationality){
            $nationality->delete();
            return response()->json([
                'message' => 'You delete nationality success'
            ]);
        }
    }
}
