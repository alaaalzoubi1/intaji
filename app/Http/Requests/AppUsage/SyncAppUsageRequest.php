<?php

namespace App\Http\Requests\AppUsage;

use Illuminate\Foundation\Http\FormRequest;

class SyncAppUsageRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'date'            => 'sometimes|date|before_or_equal:today',
            'apps'            => 'required|array|min:1|max:100',
            'apps.*.package'  => 'required|string|max:150',
            'apps.*.name'     => 'required|string|max:100',
            'apps.*.minutes'  => 'required|integer|min:0',
            'apps.*.category' => 'sometimes|in:social,entertainment,games,productivity,education,other',
        ];
    }

    public function messages(): array
    {
        return [
            'apps.required'          => 'يجب إرسال بيانات التطبيقات.',
            'apps.*.package.required' => 'اسم الحزمة مطلوب لكل تطبيق.',
            'apps.*.minutes.min'     => 'وقت الاستخدام لا يمكن أن يكون سالباً.',
        ];
    }
}
