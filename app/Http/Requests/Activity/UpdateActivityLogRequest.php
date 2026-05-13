<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityLogRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'value_bool'          => 'sometimes|boolean',
            'value_numeric'       => 'sometimes|numeric|min:0',
            'value_rating'        => 'sometimes|integer|min:1|max:5',
            'value_text'          => 'sometimes|string|max:500',
            'value_seconds'       => 'sometimes|integer|min:0',
            'failure_reason'      => 'sometimes|nullable|in:forgot,lazy,busy,tired,phone_distraction,other',
            'failure_reason_note' => 'sometimes|nullable|string|max:255',
            'note'                => 'sometimes|nullable|string|max:500',
        ];
    }
}
