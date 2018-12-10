<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryRequest extends FormRequest
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
            'type'          => 'required',
            'question_text' => 'required',
            'option1'       => 'required',
            'option2'       => 'required',
            'correct'       => 'required',
            'right_marks'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required'          => 'Question type field is required.',
            'question_text.required' => 'Question text field is required.',
            'correct.required'       => 'Please select atleast one correct answer.',
            'right_marks.required'   => 'Right marks field is required.',
            'option1'                => 'Option one field is required.',
            'option2'                => 'Option two field is required.'
        ];
    }
}
