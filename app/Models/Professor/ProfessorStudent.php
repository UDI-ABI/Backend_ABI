<?php

namespace App\Models\Professor;

use App\Models\Student;

class ProfessorStudent extends Student
{
    protected $table = 'students';

    protected $connection = 'mysql_professor';
}
