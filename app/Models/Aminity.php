<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aminity extends Model
{


    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    public function bus(){
        return $this->belongsToMany(Bus::class);}
}
