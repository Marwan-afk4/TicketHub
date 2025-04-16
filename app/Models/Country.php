<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable =[
        'name',
        'flag',
        'status'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['image_link'];

    public function getImageLinkAttribute(){
        if (isset($this->attributes['flag'])) {
            return url('storage/' . $this->attributes['flag']);
        }

        return null;
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }


}
