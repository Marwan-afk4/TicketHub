<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceFees extends Model
{
    protected $fillable =[ 
        'train',
        'bus',
        'hiace',
        'private_request', 
    ];
}
