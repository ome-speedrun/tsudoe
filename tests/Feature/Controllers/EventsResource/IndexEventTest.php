<?php

namespace Tests\Feature\Controllers\EventsResource;

use App\Usecases\Events\EventAggregation;
use App\Values\Events\EventId;
use App\Values\Events\Name;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\Slug;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\Fixtures\Factories\EventFactory;
use Tests\Fixtures\Factories\EventHoldingPeriodFactory;
use Tests\Fixtures\Factories\EventMetaFactory;
use Tests\Fixtures\Factories\EventProfileFactory;
use Tests\TestCase;

class IndexEventTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    public function testIndexEvent()
    {
        $second = $this->createEvent(
            'ome-speedrun',
            'OME Speedrun',
            'online',
            [
                new Period(
                    CarbonImmutable::create(2022, 8, 11, 10, 00),
                    CarbonImmutable::create(2022, 8, 11, 20, 00),
                ),
                new Period(
                    CarbonImmutable::create(2022, 8, 12, 10, 00),
                    CarbonImmutable::create(2022, 8, 12, 20, 00),
                ),
            ],
            CarbonImmutable::create(2022, 4, 2, 12),
        );
        $first = $this->createEvent(
            'rtaijs2022',
            'RTA in Japan Summer 2022',
            'on-site',
            [
                new Period(
                    CarbonImmutable::create(2022, 8, 11),
                    CarbonImmutable::create(2022, 8, 16),
                ),
            ],
            CarbonImmutable::create(2022, 4, 1, 12),
            submissionStartsAt: CarbonImmutable::create(2022, 4, 10),
            submissionEndsAt: CarbonImmutable::create(2022, 4, 21),
        );

        $response = $this->getRequest();

        $response->assertSuccessful();
        $response->assertJson([
            [
                'id' => $first->getId(),
                'slug' => $first->getSlug(),
                'name' => $first->getName(),
                'siteType' => 'on-site',
                'periods' => [
                    [
                        'start' => CarbonImmutable::create(2022, 8, 11)->toIso8601String(),
                        'end' => CarbonImmutable::create(2022, 8, 16)->toIso8601String(),
                    ]
                ],
                'submission' => [
                    'open' => CarbonImmutable::create(2022, 4, 10)->toIso8601String(),
                    'close' => CarbonImmutable::create(2022, 4, 21)->toIso8601String(),
                ],
                'publishedAt' => CarbonImmutable::make($first->getPublishedAt())->toIso8601String(),
            ],
            [
                'id' => $second->getId(),
                'slug' => $second->getSlug(),
                'name' => $second->getName(),
                'siteType' => 'online',
                'submission' => null,
                'periods' => [
                    [
                        'start' => CarbonImmutable::create(2022, 8, 11, 10, 00)->toIso8601String(),
                        'end' => CarbonImmutable::create(2022, 8, 11, 20, 00)->toIso8601String(),
                    ],
                    [
                        'start' => CarbonImmutable::create(2022, 8, 12, 10, 00)->toIso8601String(),
                        'end' => CarbonImmutable::create(2022, 8, 12, 20, 00)->toIso8601String(),
                    ],
                ],
                'publishedAt' => CarbonImmutable::make($second->getPublishedAt())->toIso8601String(),
            ],
        ]);
    }

    private function getRequest(): TestResponse
    {
        return $this->getJson(route('events.index'));
    }
}
