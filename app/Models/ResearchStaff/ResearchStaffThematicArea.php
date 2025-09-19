<?php

namespace App\Models\ResearchStaff;

use App\Models\ThematicArea;

class ResearchStaffThematicArea extends ThematicArea
{
    protected $table = 'thematic_areas';

    protected $connection = 'mysql_research_staff';
}
