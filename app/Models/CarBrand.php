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
}
