<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable =[
        'country_id',
        'name',
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function trips(){
        return $this->hasMany(Trip::class);
    }

    public function stations(){
        return $this->hasMany(Station::class);
    }
}
