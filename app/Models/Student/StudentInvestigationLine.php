<?php

namespace App\Models\Student;

use App\Models\InvestigationLine;

class StudentInvestigationLine extends InvestigationLine
{
    protected $table = 'investigation_lines';

    protected $connection = 'mysql_student';
}
