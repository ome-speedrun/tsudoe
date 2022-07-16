<?php

namespace App\Values\Admin;

use App\Values\ValueObject;

class DiscordId extends ValueObject
{
    public function __construct(
        public readonly string $snowflake,
    ) {}

    public function __toString(): string
    {
        return $this->snowflake;
    }

}
