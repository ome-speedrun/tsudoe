<?php

namespace App\Usecases\Events;

use App\Values\Events\HoldingPeriods;
use App\Values\Events\SiteType;
use App\Values\Events\SubmissionPeriod;

class EventMeta
{
    public function __construct(
        public readonly HoldingPeriods $holdingPeriods,
        public readonly ?SubmissionPeriod $submissionPeriod,
        public readonly SiteType $siteType,
    ) {
    }
}
