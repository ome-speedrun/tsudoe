<?php

namespace App\Usecases\Admin\Tokens;

use App\Models\Application;
use App\Values\Admin\TokenName;
use Laravel\Sanctum\NewAccessToken;

class GenerateToken
{
    public function execute(
        Application $application,
        TokenName $tokenName,
    ): NewAccessToken {
        $token = $application->createToken($tokenName);
        return $token;
    }
}
