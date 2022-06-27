<?php

namespace App\Http\Requests\Events;

use App\Rules\Events\NameRule;
use App\Rules\Events\SiteTypeRule;
use App\Rules\Events\SlugRule;
use App\Values\Events\HoldingPeriods;
use App\Values\Events\Name;
use App\Values\Events\Period;
use App\Values\Events\SiteType;
use App\Values\Events\Slug;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'slug' => ['required', new SlugRule()],
            'name' => ['required', new NameRule()],
            'siteType' => ['required', new SiteTypeRule()],
            'periods' => ['required', 'array', 'min:1'],
            'periods.*' => ['array:start,end'],
            'periods.*.start' => ['required', 'date'],
            'periods.*.end' => ['required', 'date'],
        ];
    }

    public function getSlug(): Slug
    {
        return new Slug($this->input('slug'));
    }

    public function getName(): Name
    {
        return new Name($this->input('name'));
    }

    public function getSiteType(): SiteType
    {
        return SiteType::from($this->input('siteType'));
    }

    public function getHoldingPeriods(): HoldingPeriods
    {
        return new HoldingPeriods(
            ... collect($this->input('periods'))->map(
                fn (array $value) => new Period(
                    CarbonImmutable::make($value['start']),
                    CarbonImmutable::make($value['end']),
                )
            )
        );
    }
}
