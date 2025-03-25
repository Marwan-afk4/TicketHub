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
        'role',
        'gender',
        'nationality_id',
        'code',
        'image',
    ];
    protected $appends = ['image_link'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image']) && !empty($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }
        return null;
    }
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

    public function modules()
    {
        return $this->hasMany(AgentModule::class, 'agent_id');
    }
}
