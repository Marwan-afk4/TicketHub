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
>>>>>>> 29960c8444d86c71408644d03a0a232d4788eba5
    protected $appends = ['icon_link'];

    public function getIconLinkAttribute(){
        if (isset($this->attributes['icon'])) {
            return url('storage/' . $this->attributes['icon']);
        }
        return null;
    }

<<<<<<< HEAD
=======
    public function bus(){
        return $this->belongsToMany(Bus::class);
    }
>>>>>>> 29960c8444d86c71408644d03a0a232d4788eba5
}
