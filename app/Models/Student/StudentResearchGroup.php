<?php

namespace App\Models\Student;

use App\Models\ResearchGroup;

class StudentResearchGroup extends ResearchGroup
{
    protected $table = 'research_groups';

    protected $connection = 'mysql_student';
}
