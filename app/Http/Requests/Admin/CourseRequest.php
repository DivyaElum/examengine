<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title'             => 'required|unique:exam,title,'.$id,
            'prerequisites'     => 'required_without_all:exam',
            'exam'              => 'required_without_all:prerequisites',
            'amount'            => 'required|numeric',
            'description'       => 'required',
            'discount'          => 'numeric',
            'calculated_amount' => 'required|numeric',
            'featured_image'    => 'mimes:jpeg,jpg,png,gif',
            'status'            => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'              => 'Title field is required.',
            'amount.required'             => 'Course fee field is required.',
            'calculated_amount.required'  => 'Calculated course fee field is required.',
            'status.required'             => 'Status field is required.',
            'description.required'             => 'Description field is required.',
        ];
    }
}
