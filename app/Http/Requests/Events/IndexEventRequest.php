<?php

namespace App\Http\Requests\Events;

use App\Usecases\Events\Filters\SubmissionStatus;
use Illuminate\Foundation\Http\FormRequest;

class IndexEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'offset' => ['numeric'],
            'limit' => ['numeric'],
        ];
    }

    public function getOffset(): ?int
    {
        return $this->input('offset') ? max(0, $this->input('offset')) : null;
    }

    public function getLimit(): ?int
    {
        return $this->input('limit') ? max(0, $this->input('limit')) : null;
    }

    public function getSubmissionFilter(): ?SubmissionStatus
    {
        return SubmissionStatus::tryFrom($this->query('submission'));
    }
}
