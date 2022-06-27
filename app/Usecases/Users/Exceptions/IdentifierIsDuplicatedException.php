<?php

namespace App\Usecases\Users\Exceptions;

use App\Values\Users\UserId;
use Exception;
use Throwable;

class IdentifierIsDuplicatedException extends Exception
{
    public function __construct(
        UserId $userId,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            "${userId} is duplicated identifier.",
            previous: $previous
        );
    }
}
