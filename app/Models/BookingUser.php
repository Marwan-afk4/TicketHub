<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingUser extends Model
{
    protected $fillable =[
        'name',
        'age',
        'user_id',
        'payment_id',
    ];
}
