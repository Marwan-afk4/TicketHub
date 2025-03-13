<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{


    protected $fillable =[
        'bus_id',
        'trip_id',
        'operation_type',
        'date',
        'performed_by',
        'status',
    ];

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
