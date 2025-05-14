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
        'payment_method_id',
        'status',
    ];
    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        return url('storage/' . $this->image);
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
