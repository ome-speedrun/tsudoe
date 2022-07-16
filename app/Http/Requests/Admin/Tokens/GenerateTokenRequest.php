<?php

namespace App\Http\Requests\Admin\Tokens;

use App\Http\Requests\Admin\AdminRequestTrait;
use App\Rules\Admin\TokenNameRule;
use App\Usecases\Admin\FindApplication;
use App\Values\Admin\ApplicationId;
use App\Values\Admin\TokenName;
use Illuminate\Foundation\Http\FormRequest;

class GenerateTokenRequest extends FormRequest
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
            'name' => ['required', new TokenNameRule],
        ];
    }

    public function tokenName(): TokenName
    {
        return new TokenName($this->input('name'));
    }

    public function applicationId(): ApplicationId
    {
        return new ApplicationId($this->route('applicationId'));
    }
}
