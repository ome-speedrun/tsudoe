<?php

namespace App\Http\Requests\Events;

use App\Rules\Events\SiteTypeRule;
use App\Usecases\Events\EventMeta;
use App\Values\Events\HoldingPeriods;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\SubmissionPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMetaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'periods' => ['required', 'array'],
            'periods.*' => ['array:start,end'],
            'periods.*.start' => ['required', 'date'],
            'periods.*.end' => ['required', 'date'],
            'submission' => ['array:open,close'],
            'submission.open' => ['required', 'date'],
            'submission.close' => ['required', 'date'],
            'siteType' => ['required', new SiteTypeRule()],
        ];
    }

    public function getHoldingPeriods(): HoldingPeriods
    {
        return new HoldingPeriods(
            ... collect($this->input('periods'))->map(function (array $period) {
                return new Period(
                    CarbonImmutable::make($period['start']),
                    CarbonImmutable::make($period['end']),
                );
            }),
        );
    }

    public function getSubmissionPeriod(): SubmissionPeriod
    {
        return new SubmissionPeriod(
            CarbonImmutable::make($this->input('submission.open')),
            CarbonImmutable::make($this->input('submission.close')),
        );
    }

    public function getSiteType(): SiteType
    {
        return SiteType::fromString($this->input('siteType'));
    }

    public function toMeta(): EventMeta
    {
        return new EventMeta(
            $this->getHoldingPeriods(),
            $this->getSubmissionPeriod(),
            $this->getSiteType(),
        );
    }
}
