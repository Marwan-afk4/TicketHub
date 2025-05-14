<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable =[
        'user_id',
        'currency_id',
        'amount',
        'total',
    ];
    protected $appends = ['pending_amount'];

    public function getPendingAmountAttribute(){
        if (!empty($this->attributes['total'])) {
            return $this->attributes['total'] - $this->attributes['amount'];
        }
        return null;
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    public function user(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
