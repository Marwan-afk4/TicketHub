<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingBus extends Model
{
    protected $fillable =[
        'bus_id',
        'area',
    ];
}
