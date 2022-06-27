<?php

namespace Tests\Feature\Controllers\EventsResource;

use App\Usecases\UuidGenerator;
use App\Values\Events\Slug;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Ramsey\Uuid\Uuid;
use Tests\Fixtures\Factories\EventFactory;
use Tests\Fixtures\UuidGeneratorFixture;
use Tests\TestCase;

class StoreEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testStoreEvent()
    {
        $fixedUuid = Uuid::uuid4();
        $this->app->bind(UuidGenerator::class, fn () => new UuidGeneratorFixture($fixedUuid));

        $response = $this->postRequest(
            slug: 'valid-slug-example',
            name: 'たのしいイベント',
            siteType: 'on-site',
            periods: [
                [
                    'start' => '2022-12-25 13:00:00',
                    'end' => '2022-12-31 17:00:00',
                ],
            ],
        );

        $response->assertSuccessful();
        $response->assertJson([
            'id' => $fixedUuid->toString(),
            'slug' => 'valid-slug-example',
            'name' => 'たのしいイベント',
            'siteType' => 'on-site',
            'periods' => [
                [
                    'order' => 0,
                    'start' => CarbonImmutable::create(2022, 12, 25, 13, 00)->toIso8601String(),
                    'end' => CarbonImmutable::create(2022, 12, 31, 17, 00)->toIso8601String(),
                ]
            ],
            'submission' => null,
        ]);
    }

    /** @test */
    public function testStoreFailedByDuplicatedEvent()
    {
        $slug = new Slug('duplicated');
        EventFactory::make(slug: $slug)->save();

        $response = $this->postRequest(
            slug: $slug,
            name: '重複イベント',
            siteType: 'on-site',
            periods: [
                [
                    'start' => '2022-12-25 13:00:00',
                    'end' => '2022-12-31 17:00:00',
                ],
            ],
        );

        $response->assertStatus(422);
    }


    private function postRequest(
        string $slug,
        string $name,
        string $siteType,
        array $periods,
    ): TestResponse {
        return $this->postJson(route('events.store'), [
            'slug' => $slug,
            'name' => $name,
            'siteType' => $siteType,
            'periods' => collect($periods)->map(fn ($period) => [
                'start' => $period['start'],
                'end' => $period['end'],
            ])->all(),
        ]);
    }
}
