<?php

namespace App\Http\Requests\Users;

use App\Rules\Users\IdentifierRule;
use App\Values\Users\Identifier;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'identifier' => ['required', new IdentifierRule()],
        ];
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->input('identifier'));
    }
}
