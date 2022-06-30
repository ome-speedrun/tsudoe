<?php

namespace Tests\Fixtures\Factories;

use App\Models\User;
use App\Values\Users\Identifier;
use App\Values\Users\UserId;
use Ramsey\Uuid\Uuid;

class UserFactory
{
    public static function make(
        Identifier $identifier,
        ?UserId $userId = null
    ): User {
        return new User([
            'id' => $userId ?? Uuid::uuid4(),
            'identifier' => $identifier,
        ]);
    }
}
