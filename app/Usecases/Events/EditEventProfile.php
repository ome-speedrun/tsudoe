<?php

namespace App\Usecases\Events;

use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProfile;
use App\Values\Events\Description;
use App\Values\Events\Name;

class EditEventProfile
{
    public function execute(
        Event $event,
        Name $name,
        Description $description,
    ): EventAggregation {
        $profile = EventProfile::findOrFail($event->id);

        $profile->name = $name;
        $profile->description = $description;

        $profile->save();

        $meta = EventMeta::findOrFail($event->id);

        return new EventAggregation(
            $event,
            profile: $profile,
            meta: $meta->toEntity(),
        );
    }
}
