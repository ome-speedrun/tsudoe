<?php

namespace App\Rules\Admin;

use App\Values\Admin\TokenName;
use Illuminate\Contracts\Validation\Rule;

class TokenNameRule implements Rule
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
        return TokenName::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Token name must be less or equals to 255 characters.';
    }
}
