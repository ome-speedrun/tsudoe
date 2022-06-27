<?php

namespace App\Rules\Events;

use App\Exceptions\Values\InvalidValueException;
use App\Values\Events\Name;
use Illuminate\Contracts\Validation\Rule;

class NameRule implements Rule
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
        return Name::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Event name length must be between 3 and 255.';
    }
}
