<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityLogRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'activity_id'         => 'required|exists:activities,id',
            'log_date'            => 'sometimes|date|before_or_equal:today',
            'value_bool'          => 'sometimes|boolean',
            'value_numeric'       => 'sometimes|numeric|min:0',
            'value_rating'        => 'sometimes|integer|min:1|max:5',
            'value_text'          => 'sometimes|string|max:500',
            'value_seconds'       => 'sometimes|integer|min:0',
            'input_method'        => 'sometimes|in:manual,voice,camera,quick_tap',
            'failure_reason'      => 'sometimes|in:forgot,lazy,busy,tired,phone_distraction,other',
            'failure_reason_note' => 'sometimes|string|max:255',
            'note'                => 'sometimes|string|max:500',
            'evidence_image'      => 'sometimes|image|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'activity_id.exists'       => 'النشاط غير موجود.',
            'log_date.before_or_equal' => 'لا يمكن تسجيل نشاط في المستقبل.',
        ];
    }
}
