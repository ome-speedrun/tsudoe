<?php

namespace App\Usecases\Admin;

use App\Models\Application;
use Illuminate\Support\Collection;

class ApplicationCollection
{
    /** @var Collection<Application> */
    protected Collection $collection;

    public function __construct(
        Application ...$applications
    ) {
        $this->collection = collect($applications)->sort(function (Application $a, Application $b) {
            return $a->index - $b->index;
        });
    }

    /**
     * @return Application[]
     */
    public function all(): array
    {
        return $this->collection->all();
    }
}
