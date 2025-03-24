<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[
        'payment_method_id',
        'user_id',
        'amount',
        'receipt_image',
        'travelers',
        'trip_id',
        'status',
        'total',
        'travel_date',
        'currency_id',
        'booking_id',
    ];

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
