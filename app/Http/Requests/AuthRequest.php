<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\Api\ApiResponse;
class AuthRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to access this request
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validation.required', ['attribute' => __('auth.form.lbl_email')]),
            'email.email' => __('validation.email'),
            'password.required' => __('validation.required', ['attribute' => __('auth.form.lbl_password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('auth.form.lbl_password')]),
        ];
    }

    protected function invalidJson($request, ValidationException $exception) // Accepts ValidationException
    {
        return ApiResponse::error('',$exception->validator->errors(),  JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        /*return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $exception->validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);*/
    }
/*
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $exception = new ValidationException($validator, $this->invalidJson($this, new ValidationException($validator)));
        throw $exception; // Throw the ValidationException
    }*/
}
