<?php

namespace App\Usecases\Admin;

use App\Models\Administrator;
use App\Models\Application;
use App\Values\Admin\ApplicationId;

class ShowAssignedApplication
{
    public function execute(
        ApplicationId $applicationId,
        Administrator $administrator,
    ): ?Application {
        $application = $administrator->applications()
            ->where('application_id', '=', $applicationId)
            ->first();

        return $application;
    }
}
