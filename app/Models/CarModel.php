<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable =[
        'brand_id',
        'name',
        'status',
        'image',
    ];

    public function carbrand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }
}
