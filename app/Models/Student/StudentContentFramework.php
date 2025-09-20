<?php

namespace App\Models\Student;

use App\Models\ContentFramework;

class StudentContentFramework extends ContentFramework
{
    protected $table = 'content_frameworks';

    protected $connection = 'mysql_student';
}
