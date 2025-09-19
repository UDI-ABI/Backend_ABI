<?php

namespace App\Models\ResearchStaff;

use App\Models\Framework;

class ResearchStaffFramework extends Framework 
{
    protected $table = 'frameworks';

    protected $connection = 'mysql_research_staff';
}