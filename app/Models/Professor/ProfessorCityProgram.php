<?php

namespace App\Models\Professor;

use App\Models\CityProgram;

class ProfessorCityProgram extends CityProgram
{
    protected $table = 'city_program';

    protected $connection = 'mysql_professor';
}
