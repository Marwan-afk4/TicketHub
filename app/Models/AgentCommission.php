<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    protected $fillable =[
        'user_id',
        'trip_id',
        'payment_id',
        'agent_id',
        'commission',
        'receivable_to_agent',
        'total',
    ];
}
