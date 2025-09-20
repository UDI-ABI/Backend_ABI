<?php

namespace App\Models\Student;

use App\Models\Professor;

class StudentProfessor extends Professor
{
    protected $table = 'professors';

    protected $connection = 'mysql_student';
}
