<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPosition extends Model
{
    protected $fillable = [
        'name',
    ];

    public function roles(){
        return $this->hasMany(AdminRole::class, 'admin_position_id');
    }
}
