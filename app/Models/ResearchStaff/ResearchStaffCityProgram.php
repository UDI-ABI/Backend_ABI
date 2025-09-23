<?php

namespace App\Models\ResearchStaff;

use App\Models\CityProgram;

class ResearchStaffCityProgram extends CityProgram
{
    protected $table = 'city_program';

    protected $connection = 'mysql_research_staff';
}
