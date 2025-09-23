<?php

namespace App\Models\Student;

use App\Models\Version;

class StudentVersion extends Version
{
    protected $table = 'versions';

    protected $connection = 'mysql_student';
}
