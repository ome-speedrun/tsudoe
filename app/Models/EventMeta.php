<?php

namespace App\Models;

use App\Usecases\Events\EventMeta as MetaEntity;
use App\Values\Events\HoldingPeriods;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\SubmissionPeriod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class EventMeta extends UuidModel
{
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_id',
        'site_type',
        'submission_start_at',
        'submission_end_at',
    ];

    protected $casts = [
        'submission_start_at' => 'datetime',
        'submission_end_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function holdingPeriods(): HasMany
    {
        return $this->hasMany(EventHoldingPeriod::class, 'event_id', 'event_id');
    }

    public function toEntity(): MetaEntity
    {

        /** @var Collection<int, Period> */
        $periods = $this->holdingPeriods->map(function (EventHoldingPeriod $period) {
            return new Period($period->start, $period->end);
        });
        return new MetaEntity(
            holdingPeriods: new HoldingPeriods(...$periods->values()),
            submissionPeriod: (!is_null($this->submission_start_at) && !is_null($this->submission_end_at))
            ? new SubmissionPeriod($this->submission_start_at, $this->submission_end_at)
            : null,
            siteType: SiteType::from($this->site_type),
        );
    }
}
