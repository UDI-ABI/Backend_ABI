<?php

namespace App\Models\Professor;

use App\Models\ResearchGroup;

class ProfessorResearchGroup extends ResearchGroup
{
    protected $table = 'research_groups';

    protected $connection = 'mysql_professor';
}
