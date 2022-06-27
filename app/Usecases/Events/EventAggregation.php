<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventProfile;
use App\Values\Events\EventId;
use App\Values\Events\Name;
use App\Values\Events\Slug;
use DateTimeInterface;

class EventAggregation
{
    public function __construct(
        protected Event $event,
        protected EventProfile $profile,
        public readonly EventMeta $meta,
    ) {
    }

    public function getId(): EventId
    {
        return new EventId($this->event->id);
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->event->published_at;
    }

    public function getSlug(): Slug
    {
        return new Slug($this->event->slug);
    }

    public function getName(): Name
    {
        return new Name($this->profile->name);
    }
}
