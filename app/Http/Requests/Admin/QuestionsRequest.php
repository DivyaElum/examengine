<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
        $id = base64_decode(base64_decode($this->route('question'))) ?? null;



        if(sizeof($this->all()) == 2)
        {
            return [
                'type'          => 'required',
                'category'      => 'required'
            ];
        }
        else
        {
            return [
                'type'          => 'required',
                'category'      => 'required',
                'question_text' => 'required|min:1|unique:questions,question_text,'.$id,
                'option1'       => 'required',
                'option2'       => 'required',
                'correct'       => 'required',
                'right_marks'   => 'required|numeric|gt:0'
            ];
        }
    }

    public function messages()
    {
        return [
            'type.required'          => 'Question type field is required.',
            'category.required'      => 'Question category field is required.',
            'question_text.required' => 'Type your question field is required.',
            'correct.required'       => 'Please select atleast one correct answer.',
            'right_marks.required'   => 'Right marks field is required.',
            'option1.required'       => 'Correct option A field is required.',
            'option2.required'       => 'Correct option B field is required.'
        ];
    }
}
