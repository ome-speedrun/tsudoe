<?php

namespace App\Http\Requests\Events;

use App\Rules\Events\EventIdRule;
use App\Rules\Events\SiteTypeRule;
use App\Usecases\Events\EventMeta;
use App\Values\Events\EventId;
use App\Values\Events\HoldingPeriods;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\SubmissionPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'event_id' => ['required', new EventIdRule()],
            'periods' => ['required', 'array'],
            'periods.*' => ['array:start,end'],
            'periods.*.startsAt' => ['required', 'date'],
            'periods.*.endsAt' => ['required', 'date'],
            'submission' => ['array:open,close'],
            'submission.open' => ['required', 'date'],
            'submission.close' => ['required', 'date'],
            'siteType' => ['required', new SiteTypeRule()],
        ];
    }

    public function getEventId(): EventId
    {
        return new EventId($this->input('event_id'));
    }

    public function getHoldingPeriods(): HoldingPeriods
    {
        return new HoldingPeriods(
            ... collect($this->input('holden_at'))->map(function (array $holdenAt) {
                return new Period(
                    CarbonImmutable::make($holdenAt['start']),
                    CarbonImmutable::make($holdenAt['end']),
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
