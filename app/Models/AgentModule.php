<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentModule extends Model
{
    protected $fillable =[
        'agent_id',
        'module',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class,'agent_id');
    }
}
