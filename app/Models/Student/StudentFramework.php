<?php

namespace App\Models\Student;

use App\Models\Framework;

class StudentFramework extends Framework 
{
    protected $table = 'frameworks';

    protected $connection = 'mysql_student';
}