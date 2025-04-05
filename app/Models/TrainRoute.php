<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainRoute extends Model
{
    protected $fillable =[
        'name',
        'from_country_id',
        'from_city_id',
        'to_country_id',
        'to_city_id',
    ];

    public function from_country(){
        return $this->belongsTo(Country::class, 'from_country_id');
    }

    public function from_city(){
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function to_country(){
        return $this->belongsTo(Country::class, 'to_country_id');
    }

    public function to_city(){
        return $this->belongsTo(City::class, 'to_city_id');
    }
}
