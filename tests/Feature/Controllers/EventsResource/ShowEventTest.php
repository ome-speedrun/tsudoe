<?php

namespace Tests\Feature\Controllers\EventsResource;

use App\Models\EventMeta;
use App\Usecases\Events\EventAggregation;
use App\Values\Events\EventId;
use App\Values\Events\Name;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\Slug;
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

class ShowEventTest extends TestCase
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
    public function testShowEventById()
    {
        $event = $this->createEvent(
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

        $response = $this->getRequest($event->getId());

        $response->assertSuccessful();
        $response->assertJson([
            'id' => $event->getId(),
            'slug' => $event->getSlug(),
            'name' => $event->getName(),
            'siteType' => $event->meta->siteType->value,
            'submission' => [
                'open' => CarbonImmutable::create(2022, 4, 10)->toIso8601String(),
                'close' => CarbonImmutable::create(2022, 4, 21)->toIso8601String(),
            ],
            'periods' => [
                [
                    'order' => 0,
                    'start' => CarbonImmutable::create(2022, 8, 11)->toIso8601String(),
                    'end' => CarbonImmutable::create(2022, 8, 16)->toIso8601String(),
                ],
            ],
            'publishedAt' => CarbonImmutable::make($event->getPublishedAt())->toIso8601String(),
        ]);
    }

    /** @test */
    public function testShowEventBySlug()
    {
        $event = $this->createEvent(
            'rtaijs2022',
            'RTA in Japan Summer 2022',
            'on-site',
            [
                new Period(
                    CarbonImmutable::create(2022, 8, 11),
                    CarbonImmutable::create(2022, 8, 16),
                ),
                new Period(
                    CarbonImmutable::create(2022, 8, 18),
                    CarbonImmutable::create(2022, 8, 20),
                ),
            ],
            CarbonImmutable::create(2022, 4, 3, 12),
            submissionStartsAt: CarbonImmutable::create(2022, 4, 10),
            submissionEndsAt: CarbonImmutable::create(2022, 4, 21),
        );

        $response = $this->getRequest($event->getSlug());

        $response->assertSuccessful();
        $response->assertJson([
            'id' => $event->getId(),
            'slug' => $event->getSlug(),
            'name' => $event->getName(),
            'siteType' => $event->meta->siteType->value,
            'submission' => [
                'open' => CarbonImmutable::create(2022, 4, 10)->toIso8601String(),
                'close' => CarbonImmutable::create(2022, 4, 21)->toIso8601String(),
            ],
            'periods' => [
                [
                    'order' => 0,
                    'start' => CarbonImmutable::create(2022, 8, 11)->toIso8601String(),
                    'end' => CarbonImmutable::create(2022, 8, 16)->toIso8601String(),
                ],
                [
                    'order' => 1,
                    'start' => CarbonImmutable::create(2022, 8, 18)->toIso8601String(),
                    'end' => CarbonImmutable::create(2022, 8, 20)->toIso8601String(),
                ],
            ],
            'publishedAt' => CarbonImmutable::make($event->getPublishedAt())->toIso8601String(),
        ]);
    }

    /** @test */
    public function testEventNotFound()
    {
        $response = $this->getRequest('hoge');

        $response->assertNotFound();
    }


    private function getRequest(string $identifier): TestResponse
    {
        return $this->getJson(route('events.show', ['identifier' => $identifier]));
    }
}
