<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        "schedule",
        "result"
    ];

    public function laboratory()
    {
        return $this->belongsTo('Clinicare\Models\Laboratory');
    }


    public function patient()
    {
        return $this->belongsTo('Clinicare\Models\User', 'user_id');
    }
}
