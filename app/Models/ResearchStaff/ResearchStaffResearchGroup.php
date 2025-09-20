<?php

namespace App\Models\ResearchStaff;

use App\Models\ResearchGroup;

class ResearchStaffResearchGroup extends ResearchGroup
{
    protected $table = 'research_groups';

    protected $connection = 'mysql_research_staff';
}
