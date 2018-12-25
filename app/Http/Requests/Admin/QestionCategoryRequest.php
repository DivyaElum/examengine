<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QestionCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = base64_decode(base64_decode($this->route('question_category'))) ?? null;
        return [
            'category'  => 'required|min:1|unique:question_category,category_name,'.$id,
            'status'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Category field is required.',
        ];
    }
}
