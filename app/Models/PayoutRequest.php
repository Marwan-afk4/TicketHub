<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable =[
        'agent_id',
        'amount',
        'currency_id',
        'payment_method_id',
        'description',
        'date',
        'rejected_reason',
        'status',
    ];

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function payment_method(){
        return $this->belongsTo(OperatorPaymentMethod::class, 'payment_method_id');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }
}
