<?php

namespace Tests\Fixtures;

use App\Usecases\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

class UuidGeneratorFixture extends UuidGenerator
{
    public function __construct(
        private UuidInterface $fixed
    ) {
    }

    public function generate(): UuidInterface
    {
        return $this->fixed;
    }
}
