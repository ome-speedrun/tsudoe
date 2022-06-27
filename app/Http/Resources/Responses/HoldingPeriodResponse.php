<?php

namespace App\Http\Resources\Responses;

use App\Values\Events\HoldingPeriods;
use App\Values\Events\Period;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read HoldingPeriods $resource
 */
class HoldingPeriodResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return collect($this->resource->all())->map(fn (Period $period, int $index) => [
            'order' => $index,
            'start' => CarbonImmutable::make($period->start)->toIso8601String(),
            'end' => CarbonImmutable::make($period->end)->toIso8601String(),
        ])->all();
    }
}
