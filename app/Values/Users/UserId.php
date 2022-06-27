<?php

namespace App\Values\Users;

use App\Exceptions\Values\InvalidValueException;
use App\Values\ValueObject;
use App\Values\Validators\UuidValidator;
use Ramsey\Uuid\UuidInterface;

class UserId extends ValueObject
{
    use UuidValidator;

    protected UuidInterface $value;

    /**
     * @param string $raw
     * @throws InvalidValueException
     */
    public function __construct(
        string $raw
    ) {
        $this->value = $this->validate($raw);
    }

    public function value(): UuidInterface
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value->toString();
    }

    protected function name(): string
    {
        return 'UserId';
    }
}
