<?php

namespace App\Values\Admin;

use App\Values\ValueObject;

class TokenId extends ValueObject
{
    public function __construct(
        public readonly int $value
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }

}
