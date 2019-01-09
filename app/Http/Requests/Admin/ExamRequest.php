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
            'description'       => 'required',
            'category'          => 'required',
            // 'exam_days.*.day'   => 'required',
            'duration'          => 'required|numeric|between:0.1,9.99',
            'total_question'    => 'required|numeric|gt:0',

            'amount'            => 'required|numeric|gt:0',
            'discount'          => 'numeric',
            'calculated_amount' => 'required|numeric|gt:0',
            
            'start_date'        => 'required',
            'end_date'          => 'required',
            'exam_days.*.start_time.*' => 'required',
            'exam_days.*.end_time.*' => 'required',

            'featured_image'    => 'mimes:jpeg,jpg,png,gif',
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

            'amount.required'             => 'Exam fee field is required.',
            'amount.numeric'              => 'Exam fee should be in numbers only.',
            'amount.gt'                   => 'Exam fee should be greater than 0.',
            'calculated_amount.required'  => 'Calculated exam fee field is required.',
            'calculated_amount.numeric'   => 'Calculated exam fee should be in numbers only.',
            'calculated_amount.gt'        => 'Calculated exam fee should be greater than 0.',
            'discount.numeric'            => 'Discount should be in numbers only.',
            'description.required'        => 'Description field is required.',
        ];
    }
}
