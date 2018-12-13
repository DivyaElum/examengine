<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
       return [
            'txtCategory'  => 'required',
            'txtStatus'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'txtCategory.required' => 'Category field is required.',
            'txtStatus.required'   => 'Status field is required.',
        ];
    }
}
