<?php

namespace App\Models\Student;

use App\Models\ThematicArea;

class StudentThematicArea extends ThematicArea
{
    protected $table = 'thematic_areas';

    protected $connection = 'mysql_student';
}
