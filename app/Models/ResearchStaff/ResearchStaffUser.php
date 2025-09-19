<?php

namespace App\Models\ResearchStaff;

use App\Models\User;

class ResearchStaffUser extends User
{
    protected $table = 'users';

    protected $connection = 'mysql_research_staff';
}
