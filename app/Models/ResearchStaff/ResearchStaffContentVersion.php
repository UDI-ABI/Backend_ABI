<?php

namespace App\Models\ResearchStaff;

use App\Models\ContentVersion;

class ResearchStaffContentVersion extends ContentVersion
{
    protected $table = 'content_version';

    protected $connection = 'mysql_research_staff';
}
