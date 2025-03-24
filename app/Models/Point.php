<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'points',
        'currency_id',
    ];

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
