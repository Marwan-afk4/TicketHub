<?php

namespace App\Http\Controllers\Api\Agent\Bus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bus;
use App\Models\BusType;

class BusController extends Controller
{
    public function __construct(private Bus $buses,
    private BusType $bus_type){}

    public function view(Request $request){
        $bus_type = $this->bus_type
        ->get();
        $buses = $this->buses
        ->where('agent_id', $request->user()->id)
        ->with('busType', 'aminity')
        ->get();

        return response()->json([
            'bus_type' => $bus_type,
            'buses' => $buses,
        ]);
    }

    public function create(Request $request){
        
        // 'bus_number',
        // 'bus_type_id',
        // 'bus_image',
        // 'capacity',
        // 'agent_id',
        // 'status',
        // 'type'
    }

    public function modify(){
        
    }

    public function delete(){
        
    }
}
