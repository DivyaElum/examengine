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
            'title'             => 'required|min:1|unique:exam,title,'.$id,
            'prerequisites'     => 'required_without_all:exam',
            'exam'              => 'required_without_all:prerequisites',
            'amount'            => 'required|numeric|gt:0',
            'description'       => 'required',
            'discount'          => 'numeric',
            'calculated_amount' => 'required|numeric|gt:0',
            'featured_image'    => 'mimes:jpeg,jpg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            'title.required'              => 'Title field is required.',

            'amount.required'             => 'Course fee field is required.',
            'amount.numeric'              => 'Course fee should be in numbers only.',
            'amount.gt'                   => 'Course fee should be greater than 0.',

            'calculated_amount.required'  => 'Calculated course fee field is required.',
            'calculated_amount.numeric'   => 'Calculated course fee should be in numbers only.',
            'calculated_amount.gt'        => 'Calculated course fee should be greater than 0.',

            'discount.numeric'            => 'Discount should be in numbers only.',

            'status.required'             => 'Status field is required.',
            'description.required'        => 'Description field is required.',
        ];
    }
}
