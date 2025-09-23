<?php

namespace App\Models\ResearchStaff;

use App\Models\Project;

class ResearchStaffProject extends Project
{
    protected $table = 'projects';

    protected $connection = 'mysql_research_staff';
}
