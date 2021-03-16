<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $fillable = [
        "name",
    ];


    public function laboratories()
    {
        return $this->belongsToMany(
            'Clinicare\Models\Laboratory',
            'exam_type_laboratory'
        );
    }
}
