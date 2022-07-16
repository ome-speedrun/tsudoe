<?php

namespace App\Rules\Users;

use App\Exceptions\Values\InvalidValueException;
use App\Values\Users\UserId;
use Illuminate\Contracts\Validation\Rule;

class UserIdRule implements Rule
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
        return UserId::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The user id is invalid.';
    }
}
