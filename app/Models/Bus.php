<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable =[
        'bus_number',
        'bus_type_id',
        'bus_image',
        'capacity',
        'agent_id',
        'status',
        'type'
    ];
    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        return url('storage/' . $this->attributes['bus_image']);
    }

    public function busType(){
        return $this->belongsTo(BusType::class);
    }

    public function aminity(){
        return $this->belongsToMany(Aminity::class, 'aminity_bus');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function amenities()
{
    return $this->belongsToMany(Aminity::class, 'aminity_bus', 'bus_id', 'aminity_id');
}

}
