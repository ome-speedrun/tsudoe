<?php

namespace App\Values\Events;

use App\Exceptions\Values\InvalidValueException;
use App\Values\ValueObject;

class Name extends ValueObject
{
    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 255;

    public static function isValid(string $value): bool
    {
        try {
            new self($value);
        } catch (InvalidValueException $_) {
            return false;
        }
        return true;
    }

    public function __construct(
        protected string $value
    ) {
        if (mb_strlen($value) > self::MAX_LENGTH || mb_strlen($value) < self::MIN_LENGTH) {
            throw new InvalidValueException('Event name length must be between 3 and 255');
        }
    }

    public function jsonSerialize(): mixed
    {
        return $this->__toString();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
