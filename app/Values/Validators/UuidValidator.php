<?php

namespace App\Values\Validators;

use App\Exceptions\Values\InvalidValueException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait UuidValidator
{
    abstract protected function name(): string;

    public static function isValid(string $raw): bool
    {
        return Uuid::isValid($raw);
    }

    /**
     * @param string $raw
     * @return UuidInterface Return valid UUID.
     * @throws InvalidValueException
     */
    protected function validate(string $raw): UuidInterface
    {
        $valueName = $this->name();

        if (!self::isValid($raw)) {
            throw new InvalidValueException("${raw} is invalid for ${valueName}.");
        }

        return Uuid::fromString($raw);
    }
}
