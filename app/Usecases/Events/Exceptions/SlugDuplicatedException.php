<?php

namespace App\Usecases\Events\Exceptions;

use App\Values\Events\Slug;
use Exception;
use Throwable;

class SlugDuplicatedException extends Exception
{
    public function __construct(
        Slug $slug,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            message: "${slug} is duplicated slug.",
            previous: $previous,
        );
    }
}
