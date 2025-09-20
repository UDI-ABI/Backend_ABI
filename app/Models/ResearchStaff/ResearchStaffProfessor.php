<?php

namespace App\Models\ResearchStaff;

use App\Models\Professor;

class ResearchStaffProfessor extends Professor
{
    protected $table = 'professors';

    protected $connection = 'mysql_research_staff';
}
