<?php

namespace App\Values\Admin;

use App\Exceptions\Values\InvalidValueException;
use App\Values\ValueObject;

class TokenName extends ValueObject
{
    public const MAX_LENGTH = 255;

    public static function isValid(string $value): bool
    {
        try {
            new self($value);
        } catch (InvalidValueException $e) {
            return false;
        }

        return true;
    }

    public function __construct(
        public readonly string $value
    ) {
        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new InvalidValueException('Token name must be less or equals to 255 characters.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
