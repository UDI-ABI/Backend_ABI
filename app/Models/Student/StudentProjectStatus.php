<?php

namespace App\Models\Student;

use App\Models\ProjectStatus;

class StudentProjectStatus extends ProjectStatus
{
    protected $table = 'project_statuses';

    protected $connection = 'mysql_student';
}
