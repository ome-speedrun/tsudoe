<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\UpdateMetaRequest;
use App\Usecases\Events\FindEvent;
use App\Usecases\Events\UpdateMeta;
use App\Values\Events\EventId;

class MetaUpdateController extends Controller
{
    public function __invoke(
        string $id,
        UpdateMetaRequest $request,
        FindEvent $findEvent,
        UpdateMeta $updateMeta,
    ) {
        $event = $findEvent->execute(new EventId($id));
        if (!$event) {
            return response()->noContent(404);
        }
        $updateMeta->execute(
            $event->getId(),
            $request->toMeta(),
        );

        return response()->noContent();
    }
}
