<?php

namespace App\Exceptions\Values;

use Exception;
use Throwable;

class InvalidValueException extends Exception
{
    public function __construct(
        string $message,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            previous: $previous
        );
    }
}
