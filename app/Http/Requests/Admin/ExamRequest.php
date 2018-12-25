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
            'title'             => 'required|min:4|unique:exam,title,'.$id,
            'category'          => 'required',
            'exam_questions'    => 'required',
<<<<<<< HEAD
            'duration'          => 'required|numeric',
            'total_question'   => 'required|numeric',
=======
            'duration'          => 'required|numeric|gt:0',
            'total_question'   => 'required|numeric|gt:0',
            'status'            => 'required',
>>>>>>> c608ecb5209278567fad5905ea46e83366120c80
            'exam_days.*.day'   => 'required',
            'exam_days.*.start_time.*' => 'required',
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
            'exam_days.*.start_time.*.required' => 'Exam days start time field is required.',
        ];
    }
}
