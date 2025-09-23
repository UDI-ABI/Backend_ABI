<?php

namespace App\Models\Student;

use App\Models\ContentVersion;

class StudentContentVersion extends ContentVersion
{
    protected $table = 'content_version';

    protected $connection = 'mysql_student';
}
