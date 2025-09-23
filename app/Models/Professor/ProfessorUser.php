<?php

namespace App\Models\Professor;

use App\Models\User;

class ProfessorUser extends User
{
    protected $table = 'users';

    protected $connection = 'mysql_professor';
}
