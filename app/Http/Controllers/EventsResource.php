<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\IndexEventRequest;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Resources\Responses\EventResponse;
use App\Usecases\Events\CreateNewEvent;
use App\Usecases\Events\Exceptions\SlugDuplicatedException;
use App\Usecases\Events\ExtractEvents;
use App\Usecases\Events\Filters\SubmissionFilter;
use App\Usecases\Events\FindEvent;
use App\Values\Events\EventId;
use App\Values\Events\Slug;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class EventsResource extends Controller
{
    public function index(
        IndexEventRequest $request,
        ExtractEvents $extractEvents,
    ) {
        $now = CarbonImmutable::now();

        return EventResponse::collection(
            $extractEvents->execute(
                submissionFilter: $request->getSubmissionFilter()
                    ? new SubmissionFilter(
                        $now,
                        $request->getSubmissionFilter()
                    )
                    : null,
                offset: $request->getOffset(),
                limit: $request->getLimit(),
            )->all()
        );
    }

    public function store(
        StoreEventRequest $request,
        CreateNewEvent $createNewEvent,
    ) {
        try {
            $created = $createNewEvent->execute(
                slug: $request->getSlug(),
                name: $request->getName(),
                siteType: $request->getSiteType(),
                holdingPeriods: $request->getHoldingPeriods(),
            );
        } catch (SlugDuplicatedException $_) {
            return response()->noContent(422);
        }

        return new EventResponse($created);
    }

    public function show(
        string $identifier,
        FindEvent $findEvent,
    ) {
        $event = null;
        if (EventId::isValid($identifier)) {
            $event = $findEvent->execute(new EventId($identifier));
        }
        if (Slug::isValid($identifier)) {
            $event = $findEvent->execute(new Slug($identifier));
        }

        return $event ? new EventResponse($event) : response()->noContent(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
