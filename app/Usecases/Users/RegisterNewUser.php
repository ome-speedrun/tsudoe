<?php

namespace App\Usecases\Users;

use App\Models\User;
use App\Usecases\Users\Exceptions\IdentifierIsDuplicatedException;
use App\Values\Users\UserId;
use Illuminate\Database\QueryException;

class RegisterNewUser
{
    /**
     *
     * @param UserId $userId
     * @return User
     * @throws IdentifierIsDuplicatedException Received identifier is duplicated.
     */
    public function execute(UserId $userId): User
    {
        try {
            $newUser = User::create([
                'id' => $userId,
            ]);
        } catch (QueryException $e) {
            throw new IdentifierIsDuplicatedException($userId, $e);
        }

        return $newUser->fresh();
    }
}
