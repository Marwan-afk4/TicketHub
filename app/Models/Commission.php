<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable =[
        'agent_id',
        'train',
        'bus',
        'hiace',
        'private_request',
        'type'
    ];

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }
}
