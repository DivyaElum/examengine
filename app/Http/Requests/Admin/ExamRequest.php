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
            'title'             => 'required',
            'category'          => 'required',
            'exam_questions'    => 'required',
            'duration'          => 'required|numeric',
            'total_questions'   => 'required|numeric',
            'status'            => 'required',
            'exam_days[0][day]' => 'required',
            'exam_days[0][start_time]'  => 'required',
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
