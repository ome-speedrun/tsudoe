<?php

namespace App\Usecases\Users;

use App\Models\User;
use App\Values\Users\Identifier;
use App\Values\Users\UserId;

class FindUser
{
    public function execute(UserId|Identifier $identifier): ?User
    {
        return match ($identifier::class) {
            UserId::class => User::find($identifier),
            Identifier::class => User::where('identifier', '=', $identifier)->first(),
        };
    }
}
