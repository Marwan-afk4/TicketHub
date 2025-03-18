<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\City;

class BookingController extends Controller
{
    public function __construct(private City $cities){}

    public function lists(){
        $cities = $this->cities
        ->select('id', 'name')
        ->where('status', 'active')
        ->get();

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function filter(Request $request){
        $validation = Validator::make(request()->all(),[
            'from' => 'required|string',
            'to' => 'required|string',
            'date' => 'required|in:active,inactive',
        ]);

        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],400);
        }
    }
}
