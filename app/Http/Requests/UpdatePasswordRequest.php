<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        // Allow only authenticated users
        return auth()->check();
    }

    public function rules()
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => __('validation.required', ['attribute' => __('auth.form.lbl_current_password')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.form.lbl_new_password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('auth.form.lbl_new_password')]),
            'password_confirmation.required' => __('validation.required', ['attribute' => __('auth.form.lbl_password_confirmation')]),
            'password_confirmation.same' => __('validation.same', ['attribute' => __('auth.form.lbl_password_confirmation')]),
        ];
    }
}
