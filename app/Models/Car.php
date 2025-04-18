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
        'capacity',
        'car_year',
        'status',
        'image',
    ];
    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }

        return null;
    }

    public function category(){
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function brand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function model(){
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }
}
