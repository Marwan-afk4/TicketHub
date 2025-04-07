<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable =[
        'agent_id',
        'user_id',
        'bus_id',
        'trip_id',
        'destenation_from',
        'destenation_to',
        'date',
        'seats_count',
        'status',
        'train_id',
    ];

    public function payments(){
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function train(){
        return $this->belongsTo(Train::class, 'train_id');
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

    public function agent(){
        return $this->belongsTo(User::class,'agent_id');
    }

    public function bookingUsers(){
        return $this->hasMany(BookingUser::class);
    }

    public function destnationFrom(){
        return $this->belongsTo(Station::class, 'destenation_from');
    }

    public function destnationTo(){
        return $this->belongsTo(Station::class, 'destenation_to');
    }

}
