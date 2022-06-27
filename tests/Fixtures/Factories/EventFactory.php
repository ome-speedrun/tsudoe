<?php

namespace Tests\Fixtures\Factories;

use App\Models\Event;
use App\Values\Events\EventId;
use App\Values\Events\Slug;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;

class EventFactory
{
    public static function make(
        Slug $slug,
        ?EventId $id = null,
        ?DateTimeInterface $publishedAt = null,
    ): Event {
        return new Event([
            'id' => $id ?? Uuid::uuid4(),
            'slug' => $slug,
            'published_at' => $publishedAt ?? CarbonImmutable::now(),
        ]);
    }
}
