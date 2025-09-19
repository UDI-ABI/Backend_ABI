<?php

namespace App\Models\Professor;

use App\Models\Program;

class ProfessorProgram extends Program
{
    protected $table = 'programs';

    protected $connection = 'mysql_professor';
}
