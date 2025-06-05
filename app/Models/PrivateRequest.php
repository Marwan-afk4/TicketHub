<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRequest extends Model
{
    protected $fillable = [
        'user_id',
        'agent_id',
        'date',
        'traveler',
        'country_id',
        'city_id',
        'address',
        'map',
        'category_id',
        'brand_id',
        'from_country_id',
        'from_city_id',
        'from_address',
        'from_map',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function from_country(){
        return $this->belongsTo(Country::class, 'from_country_id');
    }

    public function from_city(){
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function to_country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function to_city(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function brand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function category(){
        return $this->belongsTo(CarCategory::class, 'category_id');
    }
}
