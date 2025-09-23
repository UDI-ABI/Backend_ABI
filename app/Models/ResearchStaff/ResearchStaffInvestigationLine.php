<?php

namespace App\Models\ResearchStaff;

use App\Models\InvestigationLine;

class ResearchStaffInvestigationLine extends InvestigationLine
{
    protected $table = 'investigation_lines';

    protected $connection = 'mysql_research_staff';
}
