<?php

namespace App\Models\ResearchStaff;

use App\Models\ContentFramework;

class ResearchStaffContentFramework extends ContentFramework
{
    protected $table = 'content_frameworks';

    protected $connection = 'mysql_research_staff';
}
