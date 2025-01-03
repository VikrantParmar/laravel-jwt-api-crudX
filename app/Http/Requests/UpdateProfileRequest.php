<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        // Allow only authenticated users
        return auth()->check();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:14|regex:/^\+?[0-9]+$/',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('auth.form.lbl_first_name')]),
            'last_name.required' => __('validation.required', ['attribute' => __('auth.form.lbl_last_name')]),
            'phone_number.required' => __('validation.required', ['attribute' => __('auth.form.lbl_phone_number')]),
            'phone_number.min' => __('validation.min.string', ['attribute' => __('auth.form.lbl_phone_number')]),
            'phone_number.max' => __('validation.max.string', ['attribute' => __('auth.form.lbl_phone_number')]),
            'phone_number.regex' => __('validation.regex', ['attribute' => __('auth.form.lbl_phone_number')]),
        ];
    }
}
