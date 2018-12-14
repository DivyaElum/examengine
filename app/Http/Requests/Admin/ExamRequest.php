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
            'exam_days.*.day'   => 'required',
            'exam_days.*.start_time.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                    => 'Title field is required.',
            'category.required'                 => 'Category field is required.',
            'exam_questions.required'           => 'Wxam question field is required.',
            'duration.required'                 => 'Duration field is required.',
            'total_questions.required'          => 'Total question field is required.',
            'status.required'                   => 'Status field is required.',
            'exam_days.*.day.required'          => 'Exam days field is required.',
            'exam_days.*.start_time.*.required' => 'Exam days start time field is required.',
        ];
    }
}
