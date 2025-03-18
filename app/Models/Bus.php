<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{ 
    protected $fillable =[
        'bus_number',
        'bus_type_id',
        'capacity',
        'agent_id',
        'status'
    ];

    public function busType(){
        return $this->belongsTo(BusType::class);
    }

    public function agent(){
        return $this->belongsTo(User::class);
    }
}
