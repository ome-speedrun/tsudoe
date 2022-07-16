<?php

namespace App\Usecases\Users;

use App\Models\User;
use App\Usecases\Users\Exceptions\IdentifierIsDuplicatedException;
use App\Usecases\UuidGenerator;
use App\Values\Users\Identifier;
use App\Values\Users\UserId;
use Illuminate\Database\QueryException;

class RegisterNewUser
{
    public function __construct(
        protected UuidGenerator $uuidGenerator
    ) {
    }

    /**
     *
     * @param Identifier $identifier
     * @return User
     * @throws IdentifierIsDuplicatedException Received identifier is duplicated.
     */
    public function execute(Identifier $identifier): User
    {
        try {
            $newUser = User::create([
                'id' => new UserId($this->uuidGenerator->generate()),
                'identifier' => $identifier,
            ]);
        } catch (QueryException $e) {
            throw new IdentifierIsDuplicatedException($identifier, $e);
        }

        return $newUser->fresh();
    }
}
