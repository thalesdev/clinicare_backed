<?php

namespace Clinicare\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "adresses";
    protected $fillable = [
        "phone",
        "number",
        "complement",
        "address",
        "state",
        "district",
        "city",
        "zipcode",
    ];
}
