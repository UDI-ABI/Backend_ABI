<?php

namespace App\Models\ResearchStaff;

use App\Models\Student;

class ResearchStaffStudent extends Student
{
    protected $table = 'students';

    protected $connection = 'mysql_research_staff';
}
