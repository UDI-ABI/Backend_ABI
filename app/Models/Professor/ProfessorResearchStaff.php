<?php

namespace App\Models\Professor;

use App\Models\ResearchStaff;

class ProfessorResearchStaff extends ResearchStaff
{
    protected $table = 'research_staffs';

    protected $connection = 'mysql_professor';
}
