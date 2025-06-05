<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\PrivateRequestEmail;
use Illuminate\Support\Facades\Mail;

use App\Models\PrivateRequest;
use App\Models\User;

class PrivateRequestController extends Controller
{
    public function __construct(private PrivateRequest $private_request,
    private User $agents){}

    public function view(){
        $private_request = $this->private_request
        ->whereNull('agent_id')
        ->with(['from_country:id,name,flag', 'from_city:id,name', 
        'to_country:id,name,flag', 'to_city:id,name',
        'brand:id,name', 'category:id,name', 'user:id,name,email,phone'])
        ->get();
        $agents = $this->agents
        ->where('role', 'agent')
        ->get();

        return response()->json([
            'private_request' => $private_request,
            'agents' => $agents,
        ]);
    }

    public function determin_agent(Request $request){
        $validation = Validator::make($request->all(), [
            'agent_id'=>'required|exists:users,id',
            'private_request_id'=>'required|exists:private_requests,id',
        ]);
        if($validation->fails()){
            return response()->json($validation->errors());
        }

        $private_request = $this->private_request
        ->where('id', $request->private_request_id)
        ->first();
        $private_request->update([
            'agent_id' => $request->agent_id
        ]);
        $private_request_data = [];
        $private_request_data['user_name'] = $private_request?->user?->name;
        $private_request_data['date'] = $private_request->date;
        $private_request_data['from'] = $private_request->from_address;
        $private_request_data['to'] = $private_request->address; 
        $private_request_data['travelers'] = $private_request->traveler; 
        Mail::to($private_request_data?->agent?->email)->send(new PrivateRequestEmail($private_request_data));

        return response()->json([
            'success' => 'You determine agent success'
        ]);
    }
}
