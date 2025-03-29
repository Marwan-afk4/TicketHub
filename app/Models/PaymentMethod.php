<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'status'
    ];
    protected $appends = ['image_link'];

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }
        return null;
    }
}
