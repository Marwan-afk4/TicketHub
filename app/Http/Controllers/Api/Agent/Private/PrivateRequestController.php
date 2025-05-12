<?php

namespace App\Http\Controllers\Api\Agent\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PrivateRequest;

class PrivateRequestController extends Controller
{
    public function __construct(private PrivateRequest $private_request){}

    public function view(Request $request){
        // /agent/private_request
        $private_requests =  $this->private_request
        ->where('agent_id', $request->user()->id)
        ->with(['from_country:id,name,flag', 'from_city:id,name', 
        'to_country:id,name,flag', 'to_city:id,name',
        'brand:id,name', 'category:id,name', 'user:id,name,email,phone'])
        ->where('status', 'confirmed')
        ->get();

        return response()->json([
            'private_requests' => $private_requests
        ]);
    }

    public function cancel(Request $request, $id){
        // /agent/private_request/cancel/{id}
        $this->private_request
        ->where('agent_id', $request->user()->id)
        ->where('id', $id)
        ->update([
            'status' => 'pending'
        ]);

        return response()->json([
            'succes' => 'You cancel private request success'
        ]);
    }
}
