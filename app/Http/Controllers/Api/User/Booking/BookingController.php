<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Image;

use App\Models\City;
use App\Models\Trip;
use App\Models\PaymentMethod;
use App\Models\Payment;

class BookingController extends Controller
{
    public function __construct(private City $cities, 
    private Trip $trips, private Payment $payments, 
    private PaymentMethod $payment_methods){}
    use Image;

    public function lists(){
        // user/booking/lists
        $cities = $this->cities
        ->select('id', 'name')
        ->where('status', 'active')
        ->get();
        $payment_methods = $this->payment_methods
        ->get();

        return response()->json([
            'cities' => $cities,
            'payment_methods' => $payment_methods,
        ]);
    }

    public function filter(Request $request){
        // user/booking
        // Keys
        // from, to, date, round_date, travelers, type => [one_way, round_trip]
        $validation = Validator::make(request()->all(),[ 
            'from' => 'nullable|exists:cities,id',
            'to' => 'nullable|exists:cities,id',
            'date' => 'date|nullable',
            'round_date' => 'date|nullable',
            'travelers' => 'numeric|nullable',
            'type' => 'nullable|in:one_way,round_trip',
        ]);
        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],400);
        }
        
        $buses_trips = $this->trips
        ->with(['bus:id,bus_number,bus_image', 'pickup_station:id,name', 'dropoff_station:id,name'])
        ->where('avalible_seats', '>', 0)
        ->where('status', 'active');

        if ($request->filled('from')) {
        $buses_trips->where('city_id', $request->from);
        }
        if ($request->filled('to')) {
        $buses_trips->where('to_city_id', $request->to);
        }
        if ($request->filled('date')) {
        $buses_trips->where(function ($query) use ($request) {
            $query->where('date', $request->date)
                ->orWhere('type', 'unlimited')
                ->orWhere('fixed_date', '>=', $request->date);
        });
        }
        if ($request->filled('travelers')) {
        $buses_trips->where('avalible_seats', '>=', $request->travelers);
        }
        
        $buses_trips = $buses_trips->select(
        'id', 'bus_id', 'pickup_station_id', 'dropoff_station_id',
        'trip_name', 'deputre_time', 'arrival_time', 'date', 'avalible_seats', 'price'
        )->get();
        
        if ($request->type === 'round_trip') {
            $buses_back_trips = $this->trips
            ->with(['bus:id,bus_number,bus_image', 'pickup_station:id,name', 'dropoff_station:id,name'])
            ->where('avalible_seats', '>', 0)
            ->where('status', 'active');

        if ($request->filled('from')) {
            $buses_back_trips->where('to_city_id', $request->from);
        }
        if ($request->filled('to')) {
            $buses_back_trips->where('city_id', $request->to);
        }
        if ($request->filled('round_date')) {
            $buses_back_trips->where(function ($query) use ($request) {
                $query->where('date', $request->round_date)
                    ->orWhere('type', 'unlimited')
                    ->orWhere('fixed_date', '>=', $request->round_date);
            });
        }
        if ($request->filled('travelers')) {
            $buses_back_trips->where('avalible_seats', '>=', $request->travelers);
        }
        
        $buses_back_trips = $buses_back_trips->select(
            'id', 'bus_id', 'pickup_station_id', 'dropoff_station_id',
            'trip_name', 'deputre_time', 'arrival_time', 'date', 'avalible_seats', 'price'
        )->get();

        
        $buses_trips = $buses_trips->merge($buses_back_trips);
        }

        return response()->json([
            'buses_trips' => $buses_trips,
        ]);
    }

    public function payment(Request $request){
        $validation = Validator::make(request()->all(),[ 
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric',
            'receipt_image' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['error'=>$validation->errors()],400);
        }
        $paymentRequest = $validation->validated();
        $paymentRequest['user_id'] = $request->user()->id;
        if ($request->receipt_image && !is_string($request->receipt_image)) {
            $image_path = $this->upload($request, 'receipt_image', '/users/payment/receipt_image');
            $paymentRequest['receipt_image'] = $image_path;
        }
        $this->payments
        ->create($paymentRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
}
