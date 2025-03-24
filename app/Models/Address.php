<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable =[
        'country_id',
        'city_id',
        'address',
        'map',
    ];
}
