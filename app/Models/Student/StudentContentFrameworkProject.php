<?php

namespace App\Models\Student;

use App\Models\ContentFrameworkProject;

class StudentContentFrameworkProject extends ContentFrameworkProject
{
    protected $table = 'content_framework_project';

    protected $connection = 'mysql_student';
}