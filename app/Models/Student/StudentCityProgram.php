<?php

namespace App\Models\Student;

use App\Models\CityProgram;

class StudentCityProgram extends CityProgram
{
    protected $table = 'city_program';

    protected $connection = 'mysql_student';
}
