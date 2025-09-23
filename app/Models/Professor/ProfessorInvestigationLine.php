<?php

namespace App\Models\Professor;

use App\Models\InvestigationLine;

class ProfessorInvestigationLine extends InvestigationLine
{
    protected $table = 'investigation_lines';

    protected $connection = 'mysql_professor';
}
