<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventHoldingPeriod;
use App\Models\EventMeta;
use App\Usecases\Events\Filters\SubmissionFilter;
use App\Usecases\Events\Filters\SubmissionStatus;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

class ExtractEvents
{
    private const DEFAULT_LIMIT = 10;
    private const DEFAULT_OFFSET = 0;

    public function execute(
        ?SubmissionFilter $submissionFilter = null,
        ?int $limit = null,
        ?int $offset = null,
    ): EventAggregationCollection {
        $query = EventHoldingPeriod::with(['meta', 'meta.event'])
        ->select(['event_id', 'order', 'start'])
        ->where('order', '=', 0);
        if ($submissionFilter) {
            $submissionQuery = EventMeta::query();
            $submissionQuery = match ($submissionFilter->status) {
                SubmissionStatus::Open => $submissionQuery->where('submission_start_at', '<=', $submissionFilter->now)->where('submission_end_at', '>', $submissionFilter->now),
                SubmissionStatus::Close => $submissionQuery->where('submission_end_at', '<=', $submissionFilter->now),
                SubmissionStatus::FutureOrNothing => $submissionQuery->whereNull('submission_start_at'),
            };

            $submissionFilteredIds = $submissionQuery->select(['event_id'])->pluck('event_id');
            $query = $query->whereIn('event_id', $submissionFilteredIds->all());
        }
        $firstPeriods = $query
            ->orderBy('start')
            ->offset($offset ?? self::DEFAULT_OFFSET)
            ->limit($limit ?? self::DEFAULT_LIMIT)
            ->get();
        $eventIds = $firstPeriods->pluck('event_id');
        $events = Event::with('profile', 'meta', 'meta.holdingPeriods')
            ->select()
            ->whereIn('id', $eventIds)
            ->get();

        $sorted = $events->sortBy(fn (Event $event) => $eventIds->search($event->id));

        return new EventAggregationCollection(
            $sorted->map(fn (Event $event) => new EventAggregation($event, $event->profile, $event->meta->toEntity()))->all()
        );
    }
}
