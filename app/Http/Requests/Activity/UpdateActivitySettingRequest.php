<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivitySettingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'is_enabled'            => 'sometimes|boolean',
            'reminder_time'         => 'sometimes|nullable|date_format:H:i',
            'smart_reminder'        => 'sometimes|boolean',
            'notifications_enabled' => 'sometimes|boolean',
        ];
    }
}
