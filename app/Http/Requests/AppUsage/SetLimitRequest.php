<?php

namespace App\Http\Requests\AppUsage;

use Illuminate\Foundation\Http\FormRequest;

class SetLimitRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'app_package'         => 'nullable|string|max:150',
            'daily_limit_minutes' => 'required|integer|min:15|max:1440',
        ];
    }

    public function messages(): array
    {
        return [
            'daily_limit_minutes.min' => 'الحد الأدنى 15 دقيقة.',
            'daily_limit_minutes.max' => 'الحد الأقصى يوم كامل (1440 دقيقة).',
        ];
    }
}
