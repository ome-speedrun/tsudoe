<?php

namespace App\Rules\Events;

use App\Values\Events\EventId;
use Illuminate\Contracts\Validation\Rule;

class EventIdRule implements Rule
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
        return EventId::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The event id is invalid.';
    }
}
