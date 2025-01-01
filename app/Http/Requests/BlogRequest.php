<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id', // Category must exist in the categories table
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10024', // Optional image upload with size limit
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('blog.form.lbl_title'),
            'content.required' => trans('blog.form.lbl_content'),
            'category_id.required' => trans('blog.form.lbl_category'),
            'category_id.exists' => trans('blog.form.lbl_category'),
            'image.image' => trans('blog.form.lbl_image'),
            'image.max' => trans('blog.form.lbl_image'),
        ];
    }
}

