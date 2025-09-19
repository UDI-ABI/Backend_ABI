<?php

namespace App\Models\Professor;

use App\Models\Content;

class ProfessorContent extends Content
{
    protected $table = 'contents';

    protected $connection = 'mysql_professor';
}
