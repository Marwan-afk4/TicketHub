<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Image;
use Carbon\Carbon;

use App\Models\City;
use App\Models\Country;
use App\Models\Trip;
use App\Models\PaymentMethod;
use App\Models\PrivateRequest;
use App\Models\Payment;
use App\Models\Commission;
use App\Models\AgentCommission;
use App\Models\Booking;
use App\Models\Wallet;
use App\Models\CarCategory;
use App\Models\CurrencyPoint;
use App\Models\BookingBus;
use App\Models\BookingUser;
use App\Models\ServiceFees;
use App\Models\User;

class BookingController extends Controller
{
    public function __construct(private City $cities,
    private Country $countries,
    private Trip $trips, private Payment $payments, 
    private PaymentMethod $payment_methods,
    private Commission $commissions,
    private AgentCommission $agent_commission,
    private PrivateRequest $private_request,
    private Booking $booking,
    private Wallet $wallet,
    private CarCategory $car_category,
    private CurrencyPoint $currency_point,
    private BookingBus $booking_bus,
    private User $user,
    private BookingUser $booking_user,
    private ServiceFees $service_fees){}
    use Image;

    public function lists(){
        // user/booking/lists
        $cities = $this->cities
        ->where('status', 'active')
        ->get();
        $countries = $this->countries
        ->select('id', 'name')
        ->where('status', 'active')
        ->get();
        $payment_methods = $this->payment_methods
        ->where('status', 'active')
        ->get();
        $car_category = $this->car_category 
        ->get();

        return response()->json([
            'countries' => $countries,
            'cities' => $cities,
            'payment_methods' => $payment_methods,
            'car_category' => $car_category,
        ]);
    }

    public function filter(Request $request){
        // user/booking
        // Keys
        // from, to, date, round_date, travelers, type => [one_way, round_trip]
        $validation = Validator::make(request()->all(),[
            'from' => 'nullable|exists:cities,id',
            'to' => 'nullable|exists:cities,id',
            'date' => 'date|required',
            'round_date' => 'date|nullable',
            'travelers' => 'numeric|nullable',
            'type' => 'nullable|in:one_way,round_trip',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $buses_trips = $this->trips
        ->with(['currency:id,name,symbol','bus' => function($query){
            $query->select('id', 'bus_number', 'bus_image', 'capacity')
            ->with(['aminity:id,name,icon', 'areas']);
        }, 'pickup_station:id,name', 'dropoff_station:id,name', 
        'train' => function($query){
            $query->select('id', 'name', 'class_id', 'type_id')
            ->with(['type:id,name', 'class:id,name']);
        }])
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
                ->where('start_date', '<=', $request->date)
                ->orWhere('fixed_date', '>=', $request->date)
                ->where('start_date', '<=', $request->date);
        });
        }
        if ($request->filled('travelers')) {
        $buses_trips->where('avalible_seats', '>=', $request->travelers);
        }
        // $buses_trips->where(function ($query) {
        //     $query->where('max_book_date', '>=', date('Y-m-d'))
        //         ->orWhereNull('max_book_date');
        // });
        
        $buses_trips = $buses_trips->select(
        'id', 'bus_id', 'pickup_station_id', 'dropoff_station_id', 'trip_type',
        'trip_name', 'deputre_time', 'arrival_time', 'date', 'avalible_seats', 'price',
        'cancellation_policy', 'cancelation_pay_amount', 'cancelation_pay_value',
        'cancelation_hours', 'train_id', 'currency_id'
        )->get();
        
        if ($request->type === 'round_trip') {
            $buses_back_trips = $this->trips
            ->with(['currency:id,name,symbol','bus' => function($query){
                $query->select('id', 'bus_number', 'bus_image', 'capacity')
                ->with(['aminity:id,name,icon', 'areas']);
            }, 'pickup_station:id,name', 'dropoff_station:id,name', 
            'train' => function($query){
                $query->select('id', 'name', 'class_id', 'type_id')
                ->with(['type:id,name', 'class:id,name']);
            }])
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
                        ->where('start_date', '<=', $request->round_date)
                        ->orWhere('fixed_date', '>=', $request->round_date)
                        ->where('start_date', '<=', $request->round_date);
                });
            }
            if ($request->filled('travelers')) {
                $buses_back_trips->where('avalible_seats', '>=', $request->travelers);
            }
            // $buses_back_trips->where(function ($query) {
            //     $query->where('max_book_date', '>=', date('Y-m-d'))
            //         ->orWhereNull('max_book_date');
            // });
            
            $buses_back_trips = $buses_back_trips->select(
                'id', 'bus_id', 'pickup_station_id', 'dropoff_station_id',
                'trip_name', 'deputre_time', 'arrival_time', 'date', 'avalible_seats', 'price',
                'trip_type',
                'cancellation_policy', 'cancelation_pay_amount', 'cancelation_pay_value',
                'cancelation_hours', 'train_id', 'currency_id'
            )->get();
            
            $buses_trips = $buses_trips->merge($buses_back_trips);
        }
        $service_fees = $this->service_fees
        ->first();
        if ($request->date && $request->round_date) {
            $day = Carbon::parse($request->date)->format('l');
            $round_day = Carbon::parse($request->round_date)->format('l');
            $buses_trips = $buses_trips->map(function ($trip) use($request, $day, $round_date) {
                $trip_days = $trip->days->pluck('day');
                if (!empty($trip->days) && count($trip->days) > 0 && $trip_days->contains($day)) {
                    $trip->date = $request->date;
                    $trip->max_book_date = Carbon::parse($request->date)->subDays($trip->max_book_date)->format('Y-m-d');
                    return $trip;
                }
                if (!empty($trip->days) && count($trip->days) > 0 && $trip_days->contains($round_date)) {
                    $trip->date = $request->round_date;
                    $trip->max_book_date = Carbon::parse($request->round_date)->subDays($trip->max_book_date)->format('Y-m-d');
                    return $trip;
                } 
                if (empty($trip->days) || count($trip->days) == 0 ) {
                    $trip->date = $request->date;
                    $trip->max_book_date = Carbon::parse($request->date)->subDays($trip->max_book_date)->format('Y-m-d');
                    return $trip;
                }
                return null;
            })->filter();
        }
        elseif ($request->date) {
            $day = Carbon::parse($request->date)->format('l');
            $buses_trips = $buses_trips->map(function ($trip) use($request, $day) {
                $trip_days = $trip->days->pluck('day');
                if (!empty($trip->days) && count($trip->days) > 0 && $trip_days->contains($day)) {
                    $trip->date = $request->date;
                    $trip->max_book_date = Carbon::parse($request->date)->subDays($trip->max_book_date)->format('Y-m-d');
                    return $trip;
                }
                if (empty($trip->days) || count($trip->days) == 0 ) {
                    $trip->date = $request->date;
                    $trip->max_book_date = Carbon::parse($request->date)->subDays($trip->max_book_date)->format('Y-m-d');
                    return $trip;
                }
                return null;
            })->filter();
        }

        $buses_trips = $buses_trips->map(function ($trip) use($service_fees) {
            $bus = $trip->bus;
            if (!empty($bus)) { 
                $areas = collect($bus->areas)->pluck('area'); 
                $seats = $bus->capacity; // Number of seats
                $seats_arr = [];
            
                for ($i = 1; $i <= $seats; $i++) {
                    $seats_arr[$i] = $areas->contains($i);
                }
                $bus->new_areas = $seats_arr;
                $bus->makeHidden(['areas']);
            } 
            $fees = $service_fees->{$trip->trip_type} ?? 0;
            $fees = $trip->price * $fees / 100;
            $trip->service_fees = $fees;
            if ($trip->type == 'limited' && $trip->date > $trip->fixed_date) {
                return null;
            }
            return $trip;
        })
        ->filter()
        ->where('max_book_date', '>=', date('Y-m-d'));
        $buses = $buses_trips->where('trip_type', 'bus')->values();
        $hiace = $buses_trips->where('trip_type', 'hiace')->values();
        $train = $buses_trips->where('trip_type', 'train')->values();

        return response()->json([
            'all_trips' => $buses_trips,
            'bus_trips' => $buses,
            'hiace_trips' => $hiace,
            'train_trips' => $train,
        ]);
    }

    public function payment(Request $request){
        // user/booking/payment
        // Keys
        // payment_method_id, trip_id, travelers, amount, receipt_image, 
        // travel_date, seats[]
        // travellers_data[{name, age}]
        $validation = Validator::make(request()->all(),[ 
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'trip_id' => 'required|exists:trips,id',
            'travelers' => 'required|numeric',
            'amount' => 'required|numeric',
            'travel_date' => 'required|date',
            'seats' => 'array',
            'seats.*' => 'numeric',
            'travellers_data' => 'required|array',
            'travellers_data.*.name' => 'required',
            'travellers_data.*.age' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        if (empty($request->payment_method_id)) {
            // Using Wallet
            $trip = $this->trips
            ->where('id', $request->trip_id)
            ->first();
            $commission = $this->commissions
            ->where('agent_id', $trip->agent_id)
            ->first();
            $total = $trip->price * $request->travelers;
            $min_cost = $trip->min_cost * $request->travelers;
            $wallet = $this->wallet
            ->where('user_id', $request->user()->id)
            ->where('currency_id', $trip->currency_id)
            ->first();
            if (empty($wallet) || $total > $wallet->amount) {
                return response()->json([
                    'errors' => 'Wallet does not have ' . $total
                ], 400);
            }
            if ($request->travelers > $trip->avalible_seats) {
                return response()->json([
                    'errors' => 'travellers must not more than ' . $trip->avalible_seats
                ], 403);
            }
            if (!empty($trip->max_book_date) && date('Y-m-d') > $trip->max_book_date) {
                return response()->json([
                    'errors' => 'Max book date at ' . $trip->max_book_date
                ], 404);
            }
            $paymentRequest = $validation->validated(); 
            $paymentRequest['total'] = $total;
            $paymentRequest['user_id'] = $request->user()->id;
            $paymentRequest['currency_id'] = $trip->currency_id;
            $paymentRequest['status'] = 'confirmed';
            $booking_arr = [
                'user_id' => $request->user()->id,
                'bus_id' => $trip->bus_id,
                'trip_id' => $trip->id,
                'destenation_from' => $trip->pickup_station_id,
                'destenation_to' => $trip->dropoff_station_id,
                'date' => $request->travel_date,
                'seats_count' => $request->travelers,
                'status' => 'pending',
            ];
            if($trip->trip_type == 'bus' || $trip->trip_type == 'hiace'){
                $booking_arr['status'] = 'confirmed';
            }
            $booking = $this->booking
            ->create($booking_arr);
            $paymentRequest['booking_id'] = $booking->id;
            $payments = $this->payments
            ->create($paymentRequest);
            if (empty($commission)) {
                $commission = $this->commissions
                ->where('type', 'defult')
                ->first();
            }
            if (empty($commission)) {
                $commission = $this->commissions
                ->create([
                    'type' => 'defult',
                    'train' => 0,
                    'bus' => 0,
                    'hiace' => 0, 
                ]);
            }
            $commission_precentage = 0;
            if ($trip->trip_type == 'bus') {
                $commission_precentage = $commission->bus;
            }
            elseif ($trip->trip_type == 'hiace') {
                $commission_precentage = $commission->hiace;
            }
            elseif ($trip->trip_type == 'train') {
                $commission_precentage = $commission->train;
            }
            $commission = $total * $commission_precentage / 100;
            $receivable = $total - $commission;
            $this->agent_commission
            ->create([
                'user_id' => $request->user()->id,
                'agent_id' => $trip->agent_id,
                'trip_id' => $request->trip_id,
                'payment_id' => $payments->id,
                'commission' => $commission,
                'receivable_to_agent' => $receivable,
                'total' => $total,
            ]);
            $trip->avalible_seats -= $request->travelers;
            $trip->save();
            $wallet->amount -= $total;
            $wallet->save();
            $agent_wallet = $this->wallet
            ->where('user_id', $trip->agent_id )
            ->where('currency_id', $trip->currency_id)
            ->first();
            $agent_wallet->amount += $receivable;
            $agent_wallet->save();
            $currency_point = $this->currency_point
            ->where('currency_id', $trip->currency_id)
            ->first();
            if (!empty($currency_point)) {
                $points = intval($total / $currency_point->currencies);
                $points = $points * $currency_point->points;
                $this->user
                ->where('id', $request->user()->id)
                ->update([
                    'points' => $points + $request->user()->points,
                ]);
                $payments->points = $points;
                $payments->save();
            }
            if ($request->seats) {
                foreach ($request->seats  as $item) {
                    $this->booking_bus
                    ->create([
                        'bus_id' => $trip->bus_id,
                        'area' => $item,
                    ]);
                }
            }
            $payments->commission = $commission;
            $payments->save();
            if ($request->travellers_data) {
                foreach ( $request->travellers_data as $item) {
                    $this->booking_user
                    ->create([
                        'name' => $item['name'],
                        'age' => $item['age'],
                        'user_id' => $request->user()->id,
                        'payment_id' => $payments->id,
                    ]);
                }
            }

            return response()->json([
                'success' => 'You add data success'
            ]);
        }
        else{
            // Using payment method
            $trip = $this->trips
            ->where('id', $request->trip_id)
            ->first();
            $commission = $this->commissions
            ->where('agent_id', $trip->agent_id)
            ->first();
            $total = $trip->price * $request->travelers;
            $min_cost = $trip->min_cost * $request->travelers;
            if ($min_cost > $request->amount) {
                return response()->json([
                    'errors' => 'You must not payment less than ' . $min_cost
                ], 400);
            }
            if ($request->travelers > $trip->avalible_seats) {
                return response()->json([
                    'errors' => 'travellers must not more than ' . $trip->avalible_seats
                ], 403);
            }
            if (!empty($trip->max_book_date) && date('Y-m-d') > $trip->max_book_date) {
                return response()->json([
                    'errors' => 'Max book date at ' . $trip->max_book_date
                ], 404);
            }
            $paymentRequest = $validation->validated(); 
            $paymentRequest['total'] = $total;
            $paymentRequest['agent_id'] = $trip->agent_id;
            $paymentRequest['user_id'] = $request->user()->id;
            if ($request->receipt_image && !is_string($request->receipt_image)) {
                $image_path = $this->uploadFile($request->receipt_image, '/users/payment/receipt_image');
                $paymentRequest['receipt_image'] = $image_path;
            }
            $paymentRequest['currency_id'] = $trip->currency_id;
            $payments = $this->payments
            ->create($paymentRequest);
            if (empty($commission)) {
                $commission = $this->commissions
                ->where('type', 'defult')
                ->first();
            }
            if (empty($commission)) {
                $commission = $this->commissions
                ->create([
                    'type' => 'defult',
                    'train' => 0,
                    'bus' => 0,
                    'hiace' => 0, 
                ]);
            }
            $commission_precentage = 0;
            if ($trip->trip_type == 'bus') {
                $commission_precentage = $commission->bus;
            }
            elseif ($trip->trip_type == 'hiace') {
                $commission_precentage = $commission->hiace;
            }
            elseif ($trip->trip_type == 'train') {
                $commission_precentage = $commission->train;
            }
            $commission = $total * $commission_precentage / 100;
            $receivable = $total - $commission;
            $this->agent_commission
            ->create([
                'user_id' => $request->user()->id,
                'agent_id' => $trip->agent_id,
                'trip_id' => $request->trip_id,
                'payment_id' => $payments->id,
                'commission' => $commission,
                'receivable_to_agent' => $receivable,
                'total' => $total,
            ]);
            $trip->avalible_seats -= $request->travelers;
            $trip->save();
            $currency_point = $this->currency_point
            ->where('currency_id', $trip->currency_id)
            ->first();
            if (!empty($currency_point)) {
                $points = intval($total / $currency_point->currencies);
                $points = $points * $currency_point->points; 
                $payments->points = $points;
                $payments->save();
            }
            if ($request->seats) {
                foreach ($request->seats  as $item) {
                    $this->booking_bus
                    ->create([
                        'bus_id' => $trip->bus_id,
                        'area' => $item,
                    ]);
                }
            }
            $payments->commission = $commission;
            $payments->save();
            if ($request->travellers_data) {
                foreach ( $request->travellers_data as $item) {
                    $this->booking_user
                    ->create([
                        'name' => $item['name'],
                        'age' => $item['age'],
                        'user_id' => $request->user()->id,
                        'payment_id' => $payments->id,
                    ]);
                }
            }

            return response()->json([
                'success' => 'You add data success'
            ]);
        }
    }

    public function payment_wallet(Request $request){
        // user/booking/payment_wallet
        // Keys
        // trip_id, travelers, amount, receipt_image, travel_date
        // travellers_data[{name, age}], seats[]
        $validation = Validator::make(request()->all(),[
            'trip_id' => 'required|exists:trips,id',
            'travelers' => 'required|numeric',
            'amount' => 'required|numeric',
            'travel_date' => 'required|date',
            'travellers_data' => 'required|array',
            'travellers_data.*.name' => 'required',
            'travellers_data.*.age' => 'required',
            'seats' => 'array',
            'seats.*' => 'numeric',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        // Using Wallet
        $trip = $this->trips
        ->where('id', $request->trip_id)
        ->first();
        $commission = $this->commissions
        ->where('agent_id', $trip->agent_id)
        ->first();
        $total = $trip->price * $request->travelers;
        $min_cost = $trip->min_cost * $request->travelers;
        $wallet = $this->wallet
        ->where('user_id', $request->user()->id)
        ->where('currency_id', $trip->currency_id)
        ->first();
        if (empty($wallet) || $total > $wallet->amount) {
            return response()->json([
                'errors' => 'Wallet does not have ' . $total
            ], 400);
        }
        if ($request->travelers > $trip->avalible_seats) {
            return response()->json([
                'errors' => 'travellers must not more than ' . $trip->avalible_seats
            ], 403);
        }
        if (!empty($trip->max_book_date) && date('Y-m-d') > $trip->max_book_date) {
            return response()->json([
                'errors' => 'Max book date at ' . $trip->max_book_date
            ], 404);
        }
        $paymentRequest = $validation->validated(); 
        $paymentRequest['total'] = $total;
        $paymentRequest['user_id'] = $request->user()->id;
        $paymentRequest['currency_id'] = $trip->currency_id;
        $paymentRequest['status'] = 'confirmed';
        $booking_arr = [
            'user_id' => $request->user()->id,
            'bus_id' => $trip->bus_id,
            'trip_id' => $trip->id,
            'destenation_from' => $trip->pickup_station_id,
            'destenation_to' => $trip->dropoff_station_id,
            'date' => $request->travel_date,
            'seats_count' => $request->travelers,
            'status' => 'pending',
        ];
        if($trip->trip_type == 'bus' || $trip->trip_type == 'hiace'){
            $booking_arr['status'] = 'confirmed';
        }
        $booking = $this->booking
        ->create($booking_arr);
        $paymentRequest['booking_id'] = $booking->id;
        $payments = $this->payments
        ->create($paymentRequest);
        if (empty($commission)) {
            $commission = $this->commissions
            ->where('type', 'defult')
            ->first();
        }
        if (empty($commission)) {
            $commission = $this->commissions
            ->create([
                'type' => 'defult',
                'train' => 0,
                'bus' => 0,
                'hiace' => 0, 
            ]);
        }
        $commission_precentage = 0;
        if ($trip->trip_type == 'bus') {
            $commission_precentage = $commission->bus;
        }
        elseif ($trip->trip_type == 'hiace') {
            $commission_precentage = $commission->hiace;
        }
        elseif ($trip->trip_type == 'train') {
            $commission_precentage = $commission->train;
        }
        $commission = $total * $commission_precentage / 100;
        $receivable = $total - $commission;
        $this->agent_commission
        ->create([
            'user_id' => $request->user()->id,
            'agent_id' => $trip->agent_id,
            'trip_id' => $request->trip_id,
            'payment_id' => $payments->id,
            'commission' => $commission,
            'receivable_to_agent' => $receivable,
            'total' => $total,
        ]);
        $trip->avalible_seats -= $request->travelers;
        $trip->save();
        $wallet->amount -= $total;
        $wallet->save();
        $agent_wallet = $this->wallet
        ->where('user_id', $trip->agent_id )
        ->where('currency_id', $trip->currency_id)
        ->first();
        $agent_wallet->amount += $receivable;
        $agent_wallet->save();
        $currency_point = $this->currency_point
        ->where('currency_id', $trip->currency_id)
        ->first();
        if (!empty($currency_point)) {
            $points = intval($total / $currency_point->currencies);
            $points = $points * $currency_point->points;
            $this->user
            ->where('id', $request->user()->id)
            ->update([
                'points' => $points + $request->user()->points,
            ]);
            $payments->points = $points;
            $payments->save();
        }
        if ($request->seats) {
            foreach ($request->seats  as $item) {
                $this->booking_bus
                ->create([
                    'bus_id' => $trip->bus_id,
                    'area' => $item,
                ]);
            }
        }
        $payments->commission = $commission;
        $payments->save();
        if ($request->travellers_data) {
            foreach ( $request->travellers_data as $item) {
                $this->booking_user
                ->create([
                    'name' => $item['name'],
                    'age' => $item['age'],
                    'user_id' => $request->user()->id,
                    'payment_id' => $payments->id,
                ]);
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function private_request(Request $request){
        // user/booking/private_request
        // Keys
        // date, traveler
        // country_id, city_id, address, map
        // category_id
        // from_city_id, from_address, from_map
        $validation = Validator::make(request()->all(),[
            'date' => 'required|date',
            'traveler' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:car_categories,id',
            'address' => 'required',
            'map' => 'sometimes',       
            'from_city_id' => 'required|exists:cities,id',
            'from_address' => 'required',
            'from_map' => 'sometimes',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }
        $cities = $this->cities
        ->get(); 
        $privateRequest = $validation->validated();
        $from_country_id = $cities->where('id', $request->from_city_id)->values();
        $privateRequest['from_country_id'] = $from_country_id[0]->country_id;
        $country_id = $cities->where('id', $request->city_id)->values();
        $privateRequest['country_id'] = $country_id[0]->country_id ;
        $privateRequest['user_id'] = $request->user()->id; 
        $private_request = $this->private_request
        ->create($privateRequest);

        return response()->json([
            'success' => 'You make request success'
        ]);
    }

    public function history(Request $request){
        // /user/booking/history
        $history = $this->payments
        ->select('id', 'amount', 'total', 'status', 'travelers', 'travel_date', 'trip_id', 'booking_id')
        ->with(['trip' => function($query){
            $query->select('id', 'trip_name', 'deputre_time', 'arrival_time', 'pickup_station_id', 
            'dropoff_station_id', 'city_id', 'to_city_id')
            ->with([
                'pickup_station:id,name', 'dropoff_station:id,name',
                'city:id,name', 'to_city:id,name'
            ]);
        }])
        ->where('user_id', $request->user()->id)
        ->where('status', 'confirmed')
        ->where(function ($query) {
            $query->where('travel_date', '<', date('Y-m-d'))
                  ->orWhere(function ($q) {
                      $q->where('travel_date', date('Y-m-d'))
                        ->whereHas('trip', function ($t) {
                            $t->where('deputre_time', '<=', date('H:i:s'));
                        });
                  });
        })
        ->get()
        ->map(function($item){
            $item->travel_status = $item?->booking?->status ?? null;
            $item->makeHidden(['booking', 'booking_id']);
            return $item;
        });

        $upcoming = $this->payments
        ->select('id', 'amount', 'total', 'status', 'travelers', 'travel_date', 'trip_id', 'booking_id')
        ->with(['trip' => function($query){
            $query->select('id', 'deputre_time', 'trip_name', 'arrival_time', 'pickup_station_id', 
            'dropoff_station_id', 'city_id', 'to_city_id')
            ->with([
                'pickup_station:id,name', 'dropoff_station:id,name',
                'city:id,name', 'to_city:id,name'
            ]);
        }])
        ->where('user_id', $request->user()->id)
        ->where('status', 'confirmed')
        ->where(function ($query) {
            $query->where('travel_date', '>', date('Y-m-d'))
                  ->orWhere(function ($q) {
                      $q->where('travel_date', date('Y-m-d'))
                        ->whereHas('trip', function ($t) {
                            $t->where('deputre_time', '>', date('H:i:s'));
                        });
                  });
        })
        ->get()
        ->map(function($item){
            $item->travel_status = $item?->booking?->status ?? null;
            $item->makeHidden(['booking', 'booking_id']);
            return $item;
        });

        return response()->json([
            'history' => $history,
            'upcoming' => $upcoming
        ]);
    }

    public function cancel(Request $request, $id){
        $payments = $this->payments
        ->where('id', $id)
        ->where('user_id', $request->user()->id)
        ->with('trip')
        ->first();
        if (empty($payments)) {
            return response()->json([
                'errors' => 'id is wrong'
            ], 400);
        }
        $trip = $payments->trip;
        $fees = 0;
        $cancel_date = $payments->travel_date . ' ' . $trip->deputre_time;
        $cancel_date = Carbon::parse($cancel_date); 
        $cancel_date = $cancel_date->addHours($trip->cancelation_hours); 
        if (!empty($trip->cancelation_hours) && $cancel_date < now()) {
            if ($trip->cancelation_pay_amount == 'percentage') {
                $fees = $trip->price * $trip->cancelation_pay_value / 100;
            } 
            else {
                $fees = $trip->cancelation_pay_value;
            } 
        }
        $fees = $fees * $payments->travelers;
        $total = $payments->amount - $fees;
        $wallet = $this->wallet
        ->where('user_id', $request->user()->id)
        ->where('currency_id', $trip->currency_id)
        ->first();
        $wallet->amount += $total;
        $wallet->save();
        $booking = $this->booking
        ->where('id', $payments->booking_id)
        ->update([
            'status' => 'canceled'
        ]);
        $this->user
        ->where('id', $request->user()->id)
        ->update([
            'points' => $request->user()->points - $payments->points
        ]);

        return response()->json([
            'success' => 'You cancel trip success',
        ]);
    }
}
