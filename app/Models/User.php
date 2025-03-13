<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;

    protected $fillable =[
        'country_id',
        'city_id',
        'zone_id',
        'name',
        'email',
        'password',
        'phone',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function bus()
    {
        return $this->hasMany(Bus::class);
    }
}
