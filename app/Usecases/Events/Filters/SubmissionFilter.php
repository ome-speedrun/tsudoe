<?php

namespace App\Usecases\Events\Filters;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use DateTimeInterface;

class SubmissionFilter
{
    public readonly DateTimeImmutable $now;

    public function __construct(
        DateTimeInterface $now,
        public readonly SubmissionStatus $status,
    ) {
        $this->now = CarbonImmutable::make($now);
    }
}
