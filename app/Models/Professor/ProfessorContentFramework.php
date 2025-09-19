<?php

namespace App\Models\Professor;

use App\Models\ContentFramework;

class ProfessorContentFramework extends ContentFramework
{
    protected $table = 'content_frameworks';

    protected $connection = 'mysql_professor';
}
