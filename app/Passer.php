<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passer extends Model
{
    protected $fillable = [
        'name_of_examinee',
        'campus_eligibility',
        'school',
        'division'
    ];
}
