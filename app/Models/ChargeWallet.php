<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeWallet extends Model
{
    protected $fillable =[
        'wallet_id',
        'amount',
        'user_id',
        'image',
        'currency_id',
    ];
}
