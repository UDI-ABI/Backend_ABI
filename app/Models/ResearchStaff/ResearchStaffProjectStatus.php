<?php

namespace App\Models\ResearchStaff;

use App\Models\ProjectStatus;

class ResearchStaffProjectStatus extends ProjectStatus
{
    protected $table = 'project_statuses';

    protected $connection = 'mysql_research_staff';
}
