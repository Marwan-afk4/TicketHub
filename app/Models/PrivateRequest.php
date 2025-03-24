<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRequest extends Model
{
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'date',
        'traveler',
        'country_id',
        'city_id',
        'address',
        'map',
    ];
}
