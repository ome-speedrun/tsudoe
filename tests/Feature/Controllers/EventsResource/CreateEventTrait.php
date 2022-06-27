<?php

namespace Tests\Feature\Controllers\EventsResource;

use App\Usecases\Events\EventAggregation;
use App\Values\Events\EventId;
use App\Values\Events\Name;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\Slug;
use DateTimeInterface;
use Tests\Fixtures\Factories\EventFactory;
use Tests\Fixtures\Factories\EventHoldingPeriodFactory;
use Tests\Fixtures\Factories\EventMetaFactory;
use Tests\Fixtures\Factories\EventProfileFactory;

trait CreateEventTrait
{
    /**
     * @param string $slug
     * @param string $name
     * @param string $siteType
     * @param Period[] $periods
     * @param DateTimeInterface $publishedAt
     * @param DateTimeInterface|null $submissionStartsAt
     * @param DateTimeInterface|null $submissionEndsAt
     * @return EventAggregation
     */
    private function createEvent(
        string $slug,
        string $name,
        string $siteType,
        array $periods,
        DateTimeInterface $publishedAt,
        ?DateTimeInterface $submissionStartsAt = null,
        ?DateTimeInterface $submissionEndsAt = null,
    ): EventAggregation {
        $event = EventFactory::make(new Slug($slug), publishedAt: $publishedAt);
        $event->save();
        $profile = EventProfileFactory::make(new Name($name));
        $profile->event()->associate($event)->save();

        $meta = EventMetaFactory::make(
            new EventId($event->id),
            SiteType::from($siteType),
            $submissionStartsAt,
            $submissionEndsAt,
        );
        $meta->save();

        $meta->holdingPeriods()->saveMany(
            collect($periods)->map(fn (Period $period, int $index) => EventHoldingPeriodFactory::make(
                new EventId($event->id),
                $index,
                $period->start,
                $period->end,
            ))
        );

        return new EventAggregation($event, $profile, $meta->toEntity());
    }
}
