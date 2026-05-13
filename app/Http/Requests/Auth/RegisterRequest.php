<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:100',
            'email'    => 'nullable|email|unique:users,email|required_without:phone',
            'phone'    => 'nullable|string|max:20|unique:users,phone|required_without:email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => 'يجب إدخال البريد الإلكتروني أو رقم الهاتف.',
            'phone.required_without' => 'يجب إدخال البريد الإلكتروني أو رقم الهاتف.',
            'email.unique'           => 'البريد الإلكتروني مستخدم مسبقاً.',
            'phone.unique'           => 'رقم الهاتف مستخدم مسبقاً.',
            'password.min'           => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed'     => 'كلمتا المرور غير متطابقتين.',
        ];
    }
}
