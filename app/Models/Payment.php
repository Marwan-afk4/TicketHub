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
        'agent_id',
        'points',
        'commission',
    ];
    protected $appends = ['operator'];

    public function getOperatorAttribute(){
        return $this->total - $this->commission;
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function booking(){
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function travellers(){
        return $this->hasMany(BookingUser::class, 'payment_id');
    }
}
