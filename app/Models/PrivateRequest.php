<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRequest extends Model
{
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'date',
        'traveler',
    ];
}
