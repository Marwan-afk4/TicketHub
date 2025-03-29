<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aminity extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'status',
    ];

    protected $appends = ['icon_link'];

    public function getIconLinkAttribute(){
        if (isset($this->attributes['icon'])) {
            return url('storage/' . $this->attributes['icon']);
        }
        return null;
    }


    public function bus(){
        return $this->belongsToMany(Bus::class);
    }

}
