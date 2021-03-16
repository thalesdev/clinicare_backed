<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'password',
        'type',
        'birth',
        'crm',
        'gender',
        'birth',
        'marital_status',
        'nationality',
        'naturalness',
        'salary',
        'cpf'
    ];
    protected $hidden = [
        'password'
    ];

    public function address()
    {
        return $this->belongsTo('Clinicare\Models\Address');
    }

    public function occupation_area()
    {
        return $this->belongsTo('Clinicare\Models\OccupationArea');
    }

    public function laboratory()
    {
        return $this->hasOne('Clinicare\Models\Laboratory');
    }

    public function doctor_appointments()
    {

        return $this->hasMany(
            'Clinicare\Models\Appointment',
            'doctor_id',
            'id'
        );
    }

    public function patient_appointments()
    {

        return $this->hasMany(
            'Clinicare\Models\Appointment',
            'patient_id',
            'id'
        );
    }

    public function exams()
    {

        return $this->hasMany(
            'Clinicare\Models\Exam',
        );
    }
}
