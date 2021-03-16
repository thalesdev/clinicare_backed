<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $fillable = [
        "cnpj",
        "cnes",
        "iss",
        "employees",
        "user_id"
    ];


    public function user()
    {
        return $this->belongsTo('Clinicare\Models\User');
    }


    public function exam_types()
    {
        return $this->belongsToMany(
            'Clinicare\Models\ExamType',
            'exam_type_laboratory'
        );
    }

    public function exams()
    {

        return $this->hasMany(
            'Clinicare\Models\Exam',
        );
    }
}
