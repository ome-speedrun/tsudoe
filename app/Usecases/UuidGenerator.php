<?php

namespace App\Usecases;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidGenerator
{
    public function generate(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
