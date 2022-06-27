<?php

namespace App\Rules\Events;

use App\Values\Events\SiteType;
use Illuminate\Contracts\Validation\Rule;

class SiteTypeRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !is_null(SiteType::tryFrom($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Site type must be "on-site" or "online."';
    }
}
