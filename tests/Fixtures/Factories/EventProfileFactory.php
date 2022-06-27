<?php

namespace Tests\Fixtures\Factories;

use App\Models\EventProfile;

class EventProfileFactory
{
    public static function make(
        string $name,
        string $description = '',
    ): EventProfile {
        return new EventProfile([
            'name' => $name,
            'description' => $description,
        ]);
    }
}
