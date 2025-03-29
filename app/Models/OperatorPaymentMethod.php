<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorPaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'image',
        'status'
    ];
    protected $appends = ['image_link']; 

    public function getImageLinkAttribute(){
        if (isset($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        }
        return null;
    }
}
