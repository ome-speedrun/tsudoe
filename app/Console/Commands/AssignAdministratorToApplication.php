<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Usecases\Admin\FindDiscordUser;
use App\Usecases\Admin\ListApplications;
use App\Usecases\Admin\RegisterAdministrator;
use App\Values\Admin\DiscordId;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class AssignAdministratorToApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign administrator to application.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        ListApplications $listApplications,
        FindDiscordUser $findDiscordUser,
        RegisterAdministrator $registerAdministrator,
    ) {
        $applications = collect($listApplications->execute()->all());

        $choices = $applications->pluck('name')->all();
        $name = $this->choice('Choose application want to assign', $choices);
        $index = collect($choices)->search(fn($choice) => $choice === $name);
        $discordId = $this->ask('Discord user id');

        /** @var Application */
        $application = $applications->get($index);
        $discordUser = $findDiscordUser->execute(new DiscordId($discordId));
        $registerAdministrator->execute($discordUser, $application);

        $this->info('Assigned administrator to ' . $application->name . '!!');
    }
}
