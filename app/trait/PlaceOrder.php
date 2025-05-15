<?php

namespace App\trait;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\BranchOff;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\ProductResource;
use App\Http\Resources\AddonResource;
use App\Http\Resources\ExcludeResource;
use App\Http\Resources\ExtraResource;
use App\Http\Resources\VariationResource;
use App\Http\Resources\OptionResource;

trait PlaceOrder
{ 
    // This Traite About Place Order
    protected $paymentRequest = [
        'payment_method_id',
        'trip_id',
        'travelers',
        'amount',
        'travel_date',
        'travel_date',
    ];
    protected $orderRequest = ['user_id', 'cart'];
    protected $priceCycle;
    // paymentMethod, 
    public function placeOrder($request, $user)
    {

        // Start Make Payment
        $paymentRequest = $request->only($this->paymentRequest);
      
            $activePaymentMethod = $this->payment_methods->where('status', 1)->find($paymentRequest['payment_method_id']);
            if (!$activePaymentMethod) {
                return response()->json([
                    'paymentMethod.message' => 'This Payment Method Unavailable ',
                ], 404);
            }
            $order = $this->make_order($request, 1);
            if (isset($order['errors']) && !empty($order['errors'])) {
                return $order;
            }
        // End Make Payment

        return [
            'payment' => $order['payment'], 
            'items' => $order['items'],
        ];
    }

    // private function createOrdersForItems(array $items, string $field, array $baseData)
    // {

    //     $createdOrders = [];
    //     $count = 1;
    //     foreach ($items as $item) {
    //         // Ensure $item is an array
    //         // return $items; 
    //         if (!is_array($item)) {
    //             throw new \InvalidArgumentException("Each item should be an array.");
    //         }
    //         $periodPrice = $item['price_cycle'];

    //         // Determine the model based on the $field
    //         $itemName = match ($field) {
    //             'extra_id' => 'extra',
    //             'domain_id' => 'domain',
    //             'plan_id' => 'plan',
    //             default => throw new \InvalidArgumentException("Invalid field provided: $field"),
    //         };
    //         $model = $this->$itemName->find($item[$field]);
    //         $this->priceCycle = $model->$periodPrice ?? $model->price;
    //         // Prepare the order data

    //         $orderData = array_merge($baseData, [
    //             $field => $item[$field],
    //             'price_cycle' => $periodPrice, // Add price_cycle here
    //             'price_item' => $this->priceCycle, // Add price_item here
    //         ]);

    //         // Validate if item has the field key
    //         if (!isset($item[$field])) {
    //             throw new \InvalidArgumentException("Missing $field key in item.");
    //         }
    //         // Create the order and retrieve the model
    //         $createdOrder = $this->order->create($orderData);
    //         // Prepare the item data
    //         $itemData = [
    //             'name' => $model->name,
    //             'amount_cents' => $this->priceCycle ?? $model->price,
    //             'period' => $item['price_cycle'],
    //             'quantity' => $count,
    //             'description' => "Your Item is $model->name and Price: " . $this->priceCycle ?? $model->price,
    //         ];

    //         $createdOrders[] = $itemData;
    //     }

    //     return $createdOrders;
    // }



    public function payment_approve($payment)
    {
        if ($payment) {
            $payment->update(['status' => 'confirmed']);
            return true;
        }
        return false;
    }

    public function make_order($request, $paymob = 0){
      
        $paymentRequest = $request->only($this->paymentRequest); 
       
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
            return [
                'errors' => 'You must not payment less than ' . $min_cost
            ];
        }
        if ($request->travelers > $trip->avalible_seats) {
            return [
                'errors' => 'travellers must not more than ' . $trip->avalible_seats
            ];
        }
        if (!empty($trip->max_book_date)) {
            $max_book_date = Carbon::parse($request->travel_date)->subHours($trip->max_book_date);
            if (now() > $max_book_date) {
                return [
                    'errors' => 'Max book date at ' . $max_book_date
                ];
            }
        } 
        $paymentRequest['total'] = $total;
        $paymentRequest['agent_id'] = $trip->agent_id;
        $paymentRequest['user_id'] = $request->user()->id;
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
        elseif ($trip->trip_type == 'hiace' || $trip->trip_type == 'MiniVan') {
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
        
        if ($paymob) {
            $payments->status = 'failed';
        }
        $payments->save();

        $items[] = [ "name"=> $trip->trip_name,
            "amount_cents"=> $payments->amount,
            "description"=> 'Welcome',
            "quantity"=> $payments->travelers
        ];
        $items = $items;

        return [
            'payment' => $payments, 
            'items' => $items,
        ];
    }

}
