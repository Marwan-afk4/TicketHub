<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function filter(){

    }
}
