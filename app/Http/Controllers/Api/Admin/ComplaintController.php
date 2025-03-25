<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{


    public function getComplaint(){
        $complaints = Complaint::all();
        $data = [
            'complaints' => $complaints
        ];
        return response()->json($data);
    }

    public function addComplaint(Request $request){
        $my_id = $request->user();
        $validation = Validator::make(request()->all(), [
            'user_id' => 'nullable|exists:users,id',
            'subject_id' => 'required|exists:complaint_subjects,id',
            'message' => 'required|string',
            'date' => 'date|nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 400);
        }
        $complaint = Complaint::create([
            'user_id' => $request->user_id ?? $my_id->id,
            'subject_id' => $request->subject_id,
            'message' => $request->message,
            'date' => $request->date,
            'status' => 'pending'
        ]);
        return response()->json([
            'success' => 'Complaint added successfully',
        ]);
    }

    public function deleteComplaint($id){
        $complaint = Complaint::find($id);
        if($complaint){
            $complaint->delete();
            return response()->json(['message'=>'Complaint Deleted Successfully'],200);
        }
    }

    public function resolveComplaint($id){
        $complaint = Complaint::find($id);
        if(!$complaint){
            return response()->json(['message'=>'Complaint not found']);
        }
        else if($complaint){
            $complaint->status = 'resolved';
            $complaint->save();
            return response()->json(['message'=>'Complaint Resolved Successfully'],200);
        }
    }

    public function rejectComplaint($id){
        $complaint = Complaint::find($id);
        if(!$complaint){
            return response()->json(['message'=>'Complaint not found']);
        }
        else if($complaint){
            $complaint->status = 'canceled';
            $complaint->save();
            return response()->json(['message'=>'Complaint canceled Successfully'],200);
        }
    }
}
