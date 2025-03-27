<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $fillable =[
        'category_id',
        'name',
        'status',
        'image',
    ];

    public function carcategory(){
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function carmodels(){
        return $this->hasMany(CarModel::class, 'brand_id');
    }
}
