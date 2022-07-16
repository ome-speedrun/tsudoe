<?php

namespace App\Http\Requests\Admin\Tokens;

use App\Http\Requests\Admin\AdminRequestTrait;
use App\Usecases\Admin\FindApplication;
use App\Values\Admin\ApplicationId;
use App\Values\Admin\TokenId;
use Illuminate\Foundation\Http\FormRequest;

class RevokeTokenRequest extends FormRequest
{
    use AdminRequestTrait;

    public function __construct(
        protected FindApplication $findApplication
    ) {}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorizeApplication(
            $this,
            $this->findApplication,
            $this->applicationId(),
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['required'],
        ];
    }

    public function tokenId(): TokenId
    {
        return new TokenId($this->input('id'));
    }

    public function applicationId(): ApplicationId
    {
        return new ApplicationId($this->route('applicationId'));
    }
}
