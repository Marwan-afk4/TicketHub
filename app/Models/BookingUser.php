<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingUser extends Model
{
    protected $fillable =[
        'name',
        'age',
        'user_id',
        'payment_id',
        'booking_id',
        'private_request_id',
    ];

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function privateRequest(){
        return $this->belongsTo(PrivateRequest::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
