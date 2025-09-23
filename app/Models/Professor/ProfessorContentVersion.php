<?php

namespace App\Models\Professor;

use App\Models\ContentVersion;

class ProfessorContentVersion extends ContentVersion
{
    protected $table = 'content_version';

    protected $connection = 'mysql_professor';
}
