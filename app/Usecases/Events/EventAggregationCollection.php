<?php

namespace App\Usecases\Events;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class EventAggregationCollection
{
    /** @var Collection<EventAggregation> */
    protected Collection $events;

    public function __construct(
        array $events
    ) {
        $this->events = collect($events);
        if ($this->events->some(fn ($event) => !($event instanceof EventAggregation))) {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return EventAggregation[]
     */
    public function all(): array
    {
        return $this->events->all();
    }
}
