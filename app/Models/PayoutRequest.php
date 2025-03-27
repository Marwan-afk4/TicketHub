<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable =[
        'agent_id',
        'amount',
        'currency_id',
        'date',
        'rejected_reason',
        'status',
    ];
}
