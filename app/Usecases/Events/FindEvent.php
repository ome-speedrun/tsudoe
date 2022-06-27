<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProfile;
use App\Values\Events\EventId;
use App\Values\Events\Slug;

class FindEvent
{
    public function execute(EventId|Slug $identifier): ?EventAggregation
    {
        $event = match ($identifier::class) {
            EventId::class => $this->findById($identifier),
            Slug::class => $this->findBySlug($identifier),
        };

        if (!$event) {
            return null;
        }

        $profile = EventProfile::findOrFail($event->id);
        $meta = EventMeta::findOrFail($event->id);

        return new EventAggregation(
            $event,
            profile: $profile,
            meta: $meta->toEntity(),
        );
    }

    private function findById(EventId $id): ?Event
    {
        return Event::find($id);
    }

    private function findBySlug(Slug $slug): ?Event
    {
        return Event::where('slug', '=', $slug)->first();
    }
}
