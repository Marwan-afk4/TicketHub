<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{


    protected $fillable =[
        'user_id',
        'subject_id',
        'date',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subject(){
        return $this->belongsTo(ComplaintSubject::class);
    }
}
