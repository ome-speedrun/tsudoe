<?php

namespace App\Usecases\Users\Exceptions;

use App\Values\Users\Identifier;
use Exception;
use Throwable;

class IdentifierIsDuplicatedException extends Exception
{
    public function __construct(
        Identifier $identifier,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            "${identifier} is duplicated identifier.",
            previous: $previous
        );
    }
}
