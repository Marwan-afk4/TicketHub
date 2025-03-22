<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable =[
        'name',
        'flag',
        'status'
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    
}
