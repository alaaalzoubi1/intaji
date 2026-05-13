<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'                   => 'sometimes|string|max:100',
            'email'                  => ['sometimes', 'email', Rule::unique('users')->ignore($userId)],
            'phone'                  => ['sometimes', 'string', 'max:20', Rule::unique('users')->ignore($userId)],
            'avatar'                 => 'sometimes|image|max:2048',
            'dark_mode'              => 'sometimes|boolean',
            'language'               => 'sometimes|in:ar,en',
            'notifications_enabled'  => 'sometimes|boolean',
            'app_tracking_enabled'   => 'sometimes|boolean',
        ];
    }
}
