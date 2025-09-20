<?php

namespace App\Models\Student;

use App\Models\Content;

class StudentContent extends Content
{
    protected $table = 'contents';

    protected $connection = 'mysql_student';
}