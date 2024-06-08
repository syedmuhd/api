<?php

namespace App\Traits;

use App\Models\User;

trait AuthorizationHelper
{
    public function isSuperAdministrator(User $user)
    {
        return $user->isSuperAdministrator();
    }
}
