<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable =[
        'user_id',
        'bus_id',
        'trip_id',
        'destenation_from',
        'destenation_to',
        'date',
        'seats_count',
        'status'
    ];

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }

}
