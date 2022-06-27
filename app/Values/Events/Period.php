<?php

namespace App\Values\Events;

use App\Exceptions\Values\InvalidValueException;
use App\Values\ValueObject;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use DateTimeImmutable;
use DateTimeInterface;

class Period
{
    protected int $lengthInSec;

    public readonly DateTimeImmutable $start;
    public readonly DateTimeImmutable $end;

    public function __construct(
        DateTimeInterface $start,
        DateTimeInterface $end,
    ) {
        $this->start = CarbonImmutable::make($start);
        $this->end = CarbonImmutable::make($end);

        if (!$this->start->isBefore($this->end)) {
            throw new InvalidValueException('Start of period must be before end of period.');
        }

        $this->lengthInSec = $this->end->diffAsCarbonInterval($this->start)->totalSeconds;
    }


    public function contains(DateTimeInterface $dt): bool
    {
        return CarbonPeriod::between($this->start, $this->end)->contains($dt);
    }
}
