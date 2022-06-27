<?php

namespace App\Values\Events;

enum SiteType: string
{
    case OnSite = 'on-site';
    case Online = 'online';

    public static function fromString(string $val): static
    {
        return match ($val) {
            'on-site' => static::OnSite,
            'online' => static::Online,
        };
    }
}
