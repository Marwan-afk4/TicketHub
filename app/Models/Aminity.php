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
<<<<<<< HEAD

    public function bus(){
        return $this->belongsToMany(Bus::class);}
=======
    protected $appends = ['icon_link'];

    public function getIconLinkAttribute(){
        if (isset($this->attributes['icon'])) {
            return url('storage/' . $this->attributes['icon']);
        }
        return null;
    }
>>>>>>> eb30b70d7a27b84b89ee7eff14ac7d4054eb9fff
}
