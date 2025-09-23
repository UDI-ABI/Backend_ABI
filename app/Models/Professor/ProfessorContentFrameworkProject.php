<?php

namespace App\Models\Professor;

use App\Models\ContentFrameworkProject;

class ProfessorContentFrameworkProject extends ContentFrameworkProject
{
    protected $table = 'content_framework_project';

    protected $connection = 'mysql_professor';
}
