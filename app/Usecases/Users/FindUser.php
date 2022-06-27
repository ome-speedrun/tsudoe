<?php

namespace App\Usecases\Users;

use App\Models\User;
use App\Values\Users\UserId;

class FindUser
{
    public function execute(UserId $userId): ?User
    {
        return User::find($userId);
    }
}
