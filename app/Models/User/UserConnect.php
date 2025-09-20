<?php

namespace App\Models\User;

use App\Models\User;

Class UserConnect extends User
{
    protected $table = 'users';

    protected $connection = 'mysql_user';

}