<?php

namespace App\Http\Resources\Responses;

use App\Values\Events\SubmissionPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read SubmissionPeriod $resource
 */
class SubmissionPeriodResponse extends JsonResource
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
            'open' => CarbonImmutable::make($this->resource->start)->toIso8601String(),
            'close' => CarbonImmutable::make($this->resource->end)->toIso8601String(),
        ];
    }
}
