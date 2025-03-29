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
    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }

        return null;
    }

    public function carbrand(){
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }
}
