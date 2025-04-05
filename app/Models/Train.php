<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable =[
        'name',
        'agent_id',
        'type_id',
        'class_id',
        'country_id',
        'route_id',
        'status',
    ];

    public function type(){
        return $this->belongsTo(TrainType::class, 'type_id');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function class(){
        return $this->belongsTo(TrainClass::class, 'class_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function route(){
        return $this->belongsTo(TrainRoute::class, 'route_id');
    }
}
