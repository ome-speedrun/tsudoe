<?php

namespace App\Values\Admin;

use App\Values\Validators\UuidValidator;
use App\Values\ValueObject;
use Ramsey\Uuid\UuidInterface;

class ApplicationId extends ValueObject
{
    use UuidValidator;

    protected UuidInterface $value;

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
        return 'ApplicationId';
    }
}
