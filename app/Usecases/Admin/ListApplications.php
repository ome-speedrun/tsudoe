<?php

namespace App\Usecases\Admin;

use App\Models\Application;

class ListApplications
{
    public function execute(): ApplicationCollection
    {
        $applications = Application::get();

        return new ApplicationCollection(...$applications);
    }
}
