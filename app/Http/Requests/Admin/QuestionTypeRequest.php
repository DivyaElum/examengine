<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class QuestionTypeRequest extends FormRequest
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
        $id = base64_decode(base64_decode($this->route('question_type'))) ?? null;
        // $id = null;
        return [

            'title' => 'required|min:4|unique:question_types,title,'.$id,
            'option' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'Title field is required.',
            'option.required' => 'Option Type field is required.',
        ];
    }
}
