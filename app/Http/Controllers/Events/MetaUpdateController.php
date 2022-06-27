<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\UpdateMetaRequest;
use App\Usecases\Events\FindEvent;
use App\Usecases\Events\UpdateMeta;

class MetaUpdateController extends Controller
{
    public function __invoke(
        UpdateMetaRequest $request,
        FindEvent $findEvent,
        UpdateMeta $updateMeta,
    ) {
        $event = $findEvent->execute($request->getEventId());
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
