<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{


    protected $fillable =[
        'name',
        'bus_image',
        'seats_count',
        'plan_image',
        'seats_image',
        'status',
    ];

    public function Bus(){
        return $this->hasMany(Bus::class);
    }
}
