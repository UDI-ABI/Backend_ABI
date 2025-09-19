<?php

namespace App\Models\Professor;

use App\Models\Framework;

class ProfessorFramework extends Framework 
{
    protected $table = 'frameworks';

    protected $connection = 'mysql_professor';
}