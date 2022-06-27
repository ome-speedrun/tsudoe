<?php

namespace Tests\Feature\Controllers\EventsResource;

use App\Usecases\Events\EventAggregation;
use App\Usecases\Events\Filters\SubmissionStatus;
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

class IndexEventFilterTest extends TestCase
{
    use RefreshDatabase;
    use CreateEventTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $period = [
            new Period(
                CarbonImmutable::create(2022, 8, 11, 10, 00),
                CarbonImmutable::create(2022, 8, 11, 20, 00),
            ),
        ];
        $publishedAt = CarbonImmutable::create(2022, 4, 2, 12);

        $now = CarbonImmutable::create(2022, 10, 10, 12, 00);
        CarbonImmutable::setTestNow($now);

        $this->createEvent(
            'open',
            'Open Submission Event',
            'online',
            $period,
            $publishedAt,
            $now->subDay(),
            $now->addDay(),
        );
        $this->createEvent(
            'close',
            'Close Submission Event',
            'online',
            $period,
            $publishedAt,
            $now->subDays(3),
            $now->subDay(),
        );
        $this->createEvent(
            'nothing',
            'No Submission Event',
            'online',
            $period,
            $publishedAt,
        );
    }

    /** @test */
    public function testFilterSubmissionIsOpened()
    {
        $response = $this->getRequest(SubmissionStatus::Open);

        $response->assertJson([
            ['slug' => 'open']
        ]);

        $response->assertJsonMissing([
            ['slug' => 'close']
        ]);
        $response->assertJsonMissing([
            ['slug' => 'nothing']
        ]);
    }


    /** @test */
    public function testFilterSubmissionIsClosed()
    {
        $response = $this->getRequest(SubmissionStatus::Close);

        $response->assertJson([
            ['slug' => 'close']
        ]);

        $response->assertJsonMissing([
            ['slug' => 'open']
        ]);
        $response->assertJsonMissing([
            ['slug' => 'nothing']
        ]);
    }

    /** @test */
    public function testFilterSubmissionNothing()
    {
        $response = $this->getRequest(SubmissionStatus::FutureOrNothing);

        $response->assertJson([
            ['slug' => 'nothing']
        ]);

        $response->assertJsonMissing([
            ['slug' => 'open']
        ]);
        $response->assertJsonMissing([
            ['slug' => 'close']
        ]);
    }

    private function getRequest(
        SubmissionStatus $status
    ): TestResponse {
        return $this->get(route('events.index', [
            'submission' => $status->value,
        ]));
    }
}
