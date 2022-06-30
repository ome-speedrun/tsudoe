<?php

namespace App\Values\Users;

use App\Values\ValueObject;

class Identifier extends ValueObject
{
    public function __construct(
        public readonly string $value
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
