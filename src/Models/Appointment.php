<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        "schedule",
        "observation",
        "prescription"
    ];

    public function doctor()
    {
        return $this->belongsTo('Clinicare\Models\User', 'doctor_id', 'id');
    }


    public function patient()
    {
        return $this->belongsTo('Clinicare\Models\User', 'patient_id', 'id');
    }
}
