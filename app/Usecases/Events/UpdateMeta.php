<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventHoldingPeriod;
use App\Models\EventMeta as MetaEloquent;
use App\Values\Events\EventId;
use App\Values\Events\Period;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UpdateMeta
{
    public function execute(
        EventId $eventId,
        EventMeta $meta
    ): EventMeta {
        DB::transaction(function () use ($eventId, $meta) {
            $metaEloquent = MetaEloquent::findOrFail($eventId);
            $metaEloquent->submission_start_at = $meta->submissionPeriod?->start;
            $metaEloquent->submission_end_at = $meta->submissionPeriod?->end;
            $metaEloquent->site_type = $meta->siteType;
            $metaEloquent->save();

            EventHoldingPeriod::query()
                ->where('event_id', '=', $eventId)
                ->delete();
            EventHoldingPeriod::upsert(
                collect($meta->holdingPeriods->all())->map(function (Period $period, int $index) use ($eventId) {
                    return [
                        'id' => Uuid::uuid4(),
                        'event_id' => $eventId,
                        'order' => $index,
                        'start' => $period->start,
                        'end' => $period->end,
                    ];
                })->all(),
                ['event_id', 'order']
            );
        });

        return $meta;
    }
}
