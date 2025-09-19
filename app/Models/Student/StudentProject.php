<?php

namespace App\Models\Student;

use App\Models\Project;

class StudentProject extends Project
{
    protected $table = 'projects';

    protected $connection = 'mysql_student';
}
