<?php

namespace App\Usecases\Admin;

use App\Models\Administrator;
use App\Models\Application;

class ListAssignedApplication
{

    private const MAX_LIMIT = 50;
    private const DEFAULT_LIMIT = 10;

    public function execute(
        Administrator $administrator,
        int $limit = self::DEFAULT_LIMIT,
        int $offset = 0,
    ): ApplicationCollection {
        $applications = $administrator->applications()
            ->orderBy('created_at')
            ->limit(min($limit, self::MAX_LIMIT))
            ->offset($offset)
            ->get();

        return new ApplicationCollection(...$applications);
    }
}
