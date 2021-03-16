<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class OccupationArea extends Model
{
    protected $table = "occupation_areas";
    protected $fillable = [
        "name",
    ];
}
