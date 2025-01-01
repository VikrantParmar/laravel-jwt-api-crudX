<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\Api\ApiResponse;
class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to access this request
    }
    public function rules()
    {
        $categoryId = $this->route('id'); // Get the category ID if updating
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $categoryId . ',id,deleted_at,NULL', // Ensure uniqueness, excluding the current category for update | Check uniqueness ignoring soft-deleted records
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('category.form.lbl_category_name')]),
            'name.string' => __('validation.string', ['attribute' => __('category.form.lbl_category_name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('category.form.lbl_category_name'), 'max' => 255]),
            'name.unique' => __('validation.unique', ['attribute' =>  __('category.form.lbl_category_name')]),
        ];
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponse::error('',$exception->validator->errors(),  JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $exception = new ValidationException($validator, $this->invalidJson($this, new ValidationException($validator)));
        throw $exception; // Throw the ValidationException
    }
}
