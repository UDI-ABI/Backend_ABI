<?php

namespace App\Models\ResearchStaff;

use App\Models\ContentFrameworkProject;

class ResearchStaffContentFrameworkProject extends ContentFrameworkProject
{
    protected $table = 'content_framework_project';

    protected $connection = 'mysql_research_staff';
}