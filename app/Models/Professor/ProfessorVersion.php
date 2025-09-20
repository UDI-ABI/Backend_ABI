<?php

namespace App\Models\Professor;

use App\Models\Version;

class ProfessorVersion extends Version
{
    protected $table = 'versions';

    protected $connection = 'mysql_professor';
}
