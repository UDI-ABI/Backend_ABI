<?php

namespace App\Models\ResearchStaff;

use App\Models\Department;

class ResearchStaffDepartment extends Department
{
    protected $table = 'departments';

    protected $connection = 'mysql_research_staff';
}
