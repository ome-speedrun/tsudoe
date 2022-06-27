<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventHoldingPeriod;
use App\Models\EventMeta as MetaEloquent;
use App\Models\EventProfile;
use App\Usecases\Events\Exceptions\SlugDuplicatedException;
use App\Usecases\UuidGenerator;
use App\Values\Events\HoldingPeriods;
use App\Values\Events\Name;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\Slug;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CreateNewEvent
{
    public function __construct(
        protected UuidGenerator $uuidGenerator
    ) {
    }

    /**
     * @param Slug $slug
     * @param Name $name
     * @param SiteType $siteType
     * @param HoldingPeriods $holdingPeriods
     * @return EventAggregation
     * @throws SlugDuplicatedException
     */
    public function execute(
        Slug $slug,
        Name $name,
        SiteType $siteType,
        HoldingPeriods $holdingPeriods,
    ): EventAggregation {
        try {
            [$created, $profile, $meta] = DB::transaction(function () use ($slug, $name, $siteType, $holdingPeriods) {
                $created = Event::create([
                    'id' => $this->uuidGenerator->generate(),
                    'slug' => $slug,
                ]);

                $profile = EventProfile::create([
                    'event_id' => $created->id,
                    'name' => $name,
                    'description' => '',
                ]);

                $meta = MetaEloquent::create([
                    'event_id' => $created->id,
                    'site_type' => $siteType->value,
                ]);
                $meta->holdingPeriods()->saveMany(
                    collect($holdingPeriods->all())->map(fn (Period $period, int $index) => new EventHoldingPeriod([
                        'id' => Uuid::uuid4(),
                        'order' => $index,
                        'start' => $period->start,
                        'end' => $period->end,
                    ]))
                );

                return [
                    $created,
                    $profile,
                    $meta->toEntity(),
                ];
            });
        } catch (QueryException $e) {
            throw new SlugDuplicatedException($slug, $e);
        }

        return new EventAggregation(
            event: $created->fresh(),
            profile: $profile->fresh(),
            meta: $meta,
        );
    }
}
