<?php

namespace Tests\Fixtures\Factories;

use App\Models\EventHoldingPeriod;
use App\Values\Events\EventId;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class EventHoldingPeriodFactory
{
    public static function make(
        EventId $eventId,
        int $order,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
    ): EventHoldingPeriod {
        return new EventHoldingPeriod([
            'id' => Uuid::uuid4(),
            'event_id' => $eventId,
            'order' => $order,
            'start' => $start,
            'end' => $end,
        ]);
    }
}
