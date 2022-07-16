<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tokens\GenerateTokenRequest;
use App\Http\Requests\Admin\Tokens\RevokeTokenRequest;
use App\Usecases\Admin\FindApplication;
use App\Usecases\Admin\Tokens\GenerateToken;
use App\Usecases\Admin\Tokens\RevokeToken;
use App\Values\Admin\ApplicationId;
use App\Values\Admin\TokenName;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function viewGenerate(
        string $applicationId,
        FindApplication $findApplication,
    ) {
        $application = $findApplication->execute(new ApplicationId($applicationId));
        if (!$application) {
            return response()->noContent(404);
        }
        return view('applications.tokens.generate', [
            'application' => $application,
        ]);
    }

    public function generate(
        string $applicationId,
        GenerateTokenRequest $request,
        FindApplication $findApplication,
        GenerateToken $generateToken,
    ) {
        $application = $findApplication->execute(new ApplicationId($applicationId));
        $newToken = $generateToken->execute(
            $application,
            $request->tokenName(),
        );

        return view('applications.tokens.confirm', [
            'application' => $application,
            'newToken' => $newToken->plainTextToken,
        ]);
    }

    public function revoke(
        string $applicationId,
        RevokeTokenRequest $request,
        FindApplication $findApplication,
        RevokeToken $revokeToken,
    ) {
        $application = $findApplication->execute(new ApplicationId($applicationId));
        if (!$application) {
            return response()->noContent(404);
        }

        $revokeToken->execute($application, $request->tokenId());
        return redirect(route('admin.applications.show', ['id' => $applicationId]));
    }
}
