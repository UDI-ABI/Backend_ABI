<?php

namespace App\Models\Professor;

use App\Models\Project;

class ProfessorProject extends Project
{
    protected $table = 'projects';

    protected $connection = 'mysql_professor';
}
