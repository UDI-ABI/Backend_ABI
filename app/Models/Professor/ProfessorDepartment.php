<?php

namespace App\Models\Professor;

use App\Models\Department;

class ProfessorDepartment extends Department
{
    protected $table = 'departments';

    protected $connection = 'mysql_professor';
}
