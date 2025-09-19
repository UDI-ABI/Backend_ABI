<?php

namespace App\Models\Professor;

use App\Models\ProjectStatus;

class ProfessorProjectStatus extends ProjectStatus
{
    protected $table = 'project_statuses';

    protected $connection = 'mysql_professor';
}
