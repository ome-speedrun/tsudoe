<?php

namespace App\Http\Requests\Users;

use App\Rules\UserIdRule;
use App\Values\Users\UserId;
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
            'identifier' => ['required', new UserIdRule()],
        ];
    }

    public function getIdentifier(): UserId
    {
        return new UserId($this->input('identifier'));
    }
}
