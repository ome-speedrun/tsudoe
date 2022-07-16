<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Usecases\Admin\ListAssignedApplication;
use App\Usecases\Admin\ShowAssignedApplication;
use App\Values\Admin\ApplicationId;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    use AuthenticateAdmin;

    public function index(
        Request $request,
        ListAssignedApplication $listAssignedApplication,
    ) {
        $applications = $listAssignedApplication->execute(
            $this->administrator($request),
        );

        return view('applications.index', [
            'applications' => $applications->all(),
        ]);
    }

    public function show(
        Request $request,
        string $id,
        ShowAssignedApplication $showAssignedApplication,
    ) {
        $application = $showAssignedApplication->execute(
            new ApplicationId($id),
            $this->administrator($request),
        );

        if (!$application) {
            return abort(404);
        }

        return view('applications.detail', [
            'application' => $application,
            'tokens' => $application->tokens,
        ]);
    }
}
