<?php

namespace App\Values\Events;

use App\Exceptions\Values\InvalidValueException;
use App\Values\ValueObject;
use Illuminate\Support\Str;

class Slug extends ValueObject
{
    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 32;

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
        if (Str::kebab(Str::camel($value)) !== $value) {
            throw new InvalidValueException('Event slug must be kebab case string.');
        }
        if (Str::ascii($value) !== $value) {
            throw new InvalidValueException('Event slug contains only ascii characters.');
        }
        if (strlen($value) < self::MIN_LENGTH || self::MAX_LENGTH < strlen($value)) {
            throw new InvalidValueException('Event slug length must be between 3 and 32.');
        }
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
