<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable =[ 
        'category_id',
        'brand_id',
        'model_id',
        'agent_id',
        'car_number',
        'car_color',
        'car_year',
        'status',
        'image',
    ];

    public function category(){
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function brand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function model(){
        return $this->belongsTo(CarModel::class, 'model_id');
    }
}
