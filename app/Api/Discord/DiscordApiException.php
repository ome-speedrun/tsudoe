<?php

namespace App\Api\Discord;

use Exception;
use Throwable;

class DiscordApiException extends Exception
{
    public function __construct(
        string $message,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            $message,
            previous: $previous,
        );
    }
}
