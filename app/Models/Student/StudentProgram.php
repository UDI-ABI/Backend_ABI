<?php

namespace App\Models\Student;

use App\Models\Program;

class StudentProgram extends Program
{
    protected $table = 'programs';

    protected $connection = 'mysql_student';
}
