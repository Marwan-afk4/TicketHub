<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $fillable =[
        'user_id',
        'name',
        'phone',
        'email',
        'status',
    ];
}
