<?php

namespace App\Models\ResearchStaff;

use App\Models\Version;

class ResearchStaffVersion extends Version
{
    protected $table = 'versions';

    protected $connection = 'mysql_research_staff';
}
