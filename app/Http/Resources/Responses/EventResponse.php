<?php

namespace App\Http\Resources\Responses;

use App\Usecases\Events\EventAggregation;
use App\Values\Events\Period;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read EventAggregation $resource
 */
class EventResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getId(),
            'slug' => $this->resource->getSlug(),
            'name' => $this->resource->getName(),
            'siteType' => $this->resource->meta->siteType,
            'submission' => $this->resource->meta->submissionPeriod
                ? new SubmissionPeriodResponse($this->resource->meta->submissionPeriod)
                : null,
            'periods' => new HoldingPeriodResponse($this->resource->meta->holdingPeriods),
            'publishedAt' => CarbonImmutable::make($this->resource->getPublishedAt())?->toIso8601String(),
        ];
    }
}
