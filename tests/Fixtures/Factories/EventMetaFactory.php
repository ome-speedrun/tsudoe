<?php

namespace Tests\Fixtures\Factories;

use App\Models\EventMeta;
use App\Values\Events\EventId;
use App\Values\Events\SiteType;
use Carbon\CarbonImmutable;
use DateTimeInterface;

class EventMetaFactory
{
    public static function make(
        EventId $id,
        SiteType $siteType = SiteType::Online,
        ?DateTimeInterface $submissionStartsAt = null,
        ?DateTimeInterface $submissionEndsAt = null,
    ): EventMeta {
        return new EventMeta([
            'event_id' => $id,
            'site_type' => $siteType->value,
            'submission_start_at' => $submissionStartsAt,
            'submission_end_at' => $submissionEndsAt,
        ]);
    }
}
