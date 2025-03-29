<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable =[
        'country_id',
        'city_id',
        'zone_id',
        'name',
        'pickup',
        'dropoff',
        'basic_station',
        'status'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }
}
