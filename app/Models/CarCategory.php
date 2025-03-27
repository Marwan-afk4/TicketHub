<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    protected $fillable =[
        'name',
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

    public function carBrands(){
        return $this->hasMany(CarBrand::class);
    }
}
