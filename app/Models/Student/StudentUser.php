<?php

namespace App\Models\Student;

use App\Models\User;

class StudentUser extends User
{
    protected $table = 'users';

    protected $connection = 'mysql_student';
}
