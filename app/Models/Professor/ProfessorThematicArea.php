<?php

namespace App\Models\Professor;

use App\Models\ThematicArea;

class ProfessorThematicArea extends ThematicArea
{
    protected $table = 'thematic_areas';

    protected $connection = 'mysql_professor';
}
