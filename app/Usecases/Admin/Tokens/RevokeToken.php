<?php

namespace App\Usecases\Admin\Tokens;

use App\Models\Application;
use App\Values\Admin\TokenId;

class RevokeToken
{
    public function execute(
        Application $application,
        TokenId $tokenId
    ): bool {

        $application->tokens()->find($tokenId)->delete();

        return true;
    }
}
