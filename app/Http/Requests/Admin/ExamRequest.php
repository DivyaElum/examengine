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
        
        $id = base64_decode(base64_decode($this->route('exam'))) ?? null;

        return [
            'title'             => 'required|min:1|unique:exam,title,'.$id,
            'category'          => 'required',
            'duration'          => 'required|numeric|between:0.1,9.99',
            'total_question'    => 'required|numeric|gt:0',
            // 'exam_days.*.day'   => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'exam_days.*.start_time.*' => 'required',
            'exam_days.*.end_time.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                    => 'Title field is required.',
            'category.required'                 => 'Category field is required.',
            'exam_questions.required'           => 'Exam question field is required.',
            'duration.required'                 => 'Duration field is required.',
            'total_question.required'           => 'Total question field is required.',
            'exam_days.*.day.required'          => 'Exam days field is required.',
            'exam_days.*.start_time.*.required' => 'Start time field is required.',
            'exam_days.*.end_time.*.required'   => 'End time field is required.',
            'duration.between'                  => 'Please enter valid duration.',
            'start_date.required'               => 'Start date field is required.',
            'end_date.required'                 => 'End date field is required.',
        ];
    }
}
