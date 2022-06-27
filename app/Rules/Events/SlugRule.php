<?php

namespace App\Rules\Events;

use App\Exceptions\Values\InvalidValueException;
use App\Values\Events\Slug;
use Illuminate\Contracts\Validation\Rule;

class SlugRule implements Rule
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
        return Slug::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The slug is invalid.';
    }
}
