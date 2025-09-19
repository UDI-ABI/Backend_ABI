<?php

namespace App\Models\ResearchStaff;

use App\Models\Content;

class ResearchStaffContent extends Content
{
    protected $table = 'contents';

    protected $connection = 'mysql_research_staff';
}
