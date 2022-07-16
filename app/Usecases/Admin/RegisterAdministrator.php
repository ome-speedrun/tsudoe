<?php

namespace App\Usecases\Admin;

use App\Models\AdminDiscord;
use App\Models\Administrator;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RegisterAdministrator
{
    public function execute(
        DiscordUser $discordUser,
        Application $application,
    ): Administrator {

        return DB::transaction(function () use ($discordUser, $application) {
            /** @var AdminDiscord|null */
            $adminDiscord = AdminDiscord::firstOrNew(
                ['discord_id' => $discordUser->id],
                ['id' => Uuid::uuid4()],
            );
            if (!$adminDiscord->exists()) {
                $administrator = Administrator::create([
                    'id' => Uuid::uuid4(),
                ]);
                $administrator->discord()->save($adminDiscord);
            } else {
                $administrator = $adminDiscord->administrator;
            }
            $application->administrators()->save($administrator);

            return $administrator;
        });
    }
}
