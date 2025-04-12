<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripDays extends Model
{
    protected $fillable = [
        'day',
        'trip_id',
    ];
}
