<?php

namespace App\Usecases\Admin;

use App\Models\AdminDiscord;
use App\Models\Administrator;

class AuthenticateAdministrator
{
    public function execute(DiscordUser $discord): ?Administrator
    {
        $adminDiscord = AdminDiscord::where('discord_id', '=', $discord->id)->first();

        return $adminDiscord?->administrator;
    }
}
