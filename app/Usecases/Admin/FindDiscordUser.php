<?php

namespace App\Usecases\Admin;

use App\Api\DiscordApiClient;
use App\Values\Admin\DiscordId;

class FindDiscordUser
{

    public function __construct(
        protected DiscordApiClient $discordApi
    ) {}

    public function execute(
        DiscordId $id,
    ): ?DiscordUser
    {
        $user = $this->discordApi->getUser($id);

        if ($user) {
            return new DiscordUser(
                $user->id,
                $user->username,
                $user->discriminator,
                $user->avatar
            );
        }

        return null;
    }
}
