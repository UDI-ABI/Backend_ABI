<?php

namespace App\Models\Student;

use App\Models\Department;

class StudentDepartment extends Department
{
    protected $table = 'departments';

    protected $connection = 'mysql_student';
}
