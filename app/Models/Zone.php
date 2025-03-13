<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{


    protected $fillable =[
        'country_id',
        'city_id',
        'name',
        'status',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function trips(){
        return $this->hasMany(Trip::class);
    }

    public function stations(){
        return $this->hasMany(Station::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
