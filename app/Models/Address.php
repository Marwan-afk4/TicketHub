<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable =[
        'zone_id',
        'address',
        'street',
        'building_num',
        'apartment',
        'additional_data',
    ];
}
