<?php

namespace Tests\Feature\Controllers;

use App\Values\Events\EventId;
use App\Values\Events\Period;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Controllers\EventsResource\CreateEventTrait;
use Tests\TestCase;

class MetaUpdateTest extends TestCase
{
    use CreateEventTrait;

    /** @test */
    public function testUpdateEventMeta()
    {
        $event = $this->createEvent(
            'rtaijs2022',
            'RTA in Japan Summer 2022',
            'online',
            [
                new Period(
                    CarbonImmutable::create(2022, 8, 11),
                    CarbonImmutable::create(2022, 8, 16),
                ),
            ],
            CarbonImmutable::create(2022, 5, 10),
        );

        $response = $this->putJson(route('events.meta.update', ['id' => $event->getId()]), [
            'periods' => [
                [
                    'start' => '2022-08-10 10:00:00',
                    'end' => '2022-08-17 24:00:00',
                ],
                [
                    'start' => '2022-08-18 9:00:00',
                    'end' => '2022-08-19 15:00:00',
                ],
            ],
            'submission' => [
                'open' => '2022-06-12',
                'close' => '2022-06-28 24:00:00',
            ],
            'siteType' => 'on-site',
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('events', [
            'id' => $event->getId(),
            'slug' => $event->getSlug(),
        ]);
        $this->assertDatabaseHas('event_holding_periods', [
            'event_id' => $event->getId(),
            'order' => 0,
            'start' => CarbonImmutable::create(2022, 8, 10, 10, 00, 00),
            'end' => CarbonImmutable::create(2022, 8, 17, 24, 00 ,00),
        ]);
        $this->assertDatabaseHas('event_holding_periods', [
            'event_id' => $event->getId(),
            'order' => 1,
            'start' => CarbonImmutable::create(2022, 8, 18, 9, 00, 00),
            'end' => CarbonImmutable::create(2022, 8, 19, 15, 00 ,00),
        ]);
        $this->assertDatabaseHas('event_metas', [
            'event_id' => $event->getId(),
            'site_type' => 'on-site',
            'submission_start_at' => CarbonImmutable::create(2022, 06, 12),
            'submission_end_at' => CarbonImmutable::create(2022, 06, 28, 24, 00, 00),
        ]);
    }
}
