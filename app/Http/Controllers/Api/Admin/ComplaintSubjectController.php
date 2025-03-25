<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintSubjectController extends Controller
{


    public function getSubjects(){
        $complaintSubjects = ComplaintSubject::all();
        $data =[
            'complaintSubjects' => $complaintSubjects
        ];
        return response()->json($data);
    }

    public function addSubject(Request $request){
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 400);
        }
        $complaintSubject = ComplaintSubject::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'success' => 'Complaint Subject added successfully',
        ]);
    }

    public function updateSubject(Request $request,$id){
        $validation = Validator::make(request()->all(), [
            'name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 400);
        }
        $complaintSubject = ComplaintSubject::find($id);
        $complaintSubject->name = $request->name;
        $complaintSubject->save();
        return response()->json([
            'success' => 'Complaint Subject updated successfully',
        ]);
    }

    public function deleteSubject($id){
        $complaintSubject = ComplaintSubject::find($id);
        if($complaintSubject){
            $complaintSubject->delete();
            return response()->json(['message'=>'Complaint Subject Deleted Successfully'],200);
        }
    }
}
