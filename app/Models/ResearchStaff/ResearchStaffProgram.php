<?php

namespace App\Models\ResearchStaff;

use App\Models\Program;

class ResearchStaffProgram extends Program
{
    protected $table = 'programs';

    protected $connection = 'mysql_research_staff';
}
