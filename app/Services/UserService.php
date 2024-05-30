<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public static function createUser(array $data)
    {
        return User::create($data);
    }
}
