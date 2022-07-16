<?php

namespace App\Http\Requests\Admin;

use App\Models\Administrator;
use App\Usecases\Admin\FindApplication;
use App\Values\Admin\ApplicationId;
use Illuminate\Http\Request;

trait AdminRequestTrait
{
    public function administrator(Request $request): ?Administrator
    {
        $administrator = $request->user('web');

        if (!$administrator instanceof Administrator) {
            return null;
        }

        return $administrator;
    }

    protected function authorizeApplication(
        Request $request,
        FindApplication $findApplication,
        ApplicationId $applicationId,
    ): bool
    {
        $application = $findApplication->execute($applicationId);
        $administrator = $this->administrator($request);
        return !is_null($application->administrators()->find($administrator->id));
    }
}
