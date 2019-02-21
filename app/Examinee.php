<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examinee extends Model
{
    protected $fillable = [
        'name_of_examinee',
        'campus_eligibility',
        'school',
        'division'
    ];
}
