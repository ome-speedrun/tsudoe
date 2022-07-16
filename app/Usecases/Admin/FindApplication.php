<?php

namespace App\Usecases\Admin;

use App\Models\Application;
use App\Values\Admin\ApplicationId;

class FindApplication
{
    public function execute(
        ApplicationId $applicationId,
    ): ?Application
    {
        return Application::find($applicationId);
    }
}
