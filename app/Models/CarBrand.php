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
    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }

        return null;
    }

    public function carcategory(){
        return $this->belongsTo(CarCategory::class, 'category_id');
    }
}
