<?php

namespace App\Values\Events;

use App\Values\ValueObject;

class Description extends ValueObject
{
    public function __construct(
        protected string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
