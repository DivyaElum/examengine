<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QestionCategoryRequest extends FormRequest
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
            'txtName'           => 'required',
            'txtEmail'          => 'required|email',
            'txtDescription'    => 'required',
            'txtDesignation'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'txtName.required'          => 'Name field is required.',
            'txtEmail.required'         => 'email field is required.',
            'txtEmail.email'            => 'email is Invalid.',
            'txtDescription.required'   => 'Description field is required.',
            'txtDesignation.required'   => 'Designation field is required.'
        ];
    }
}
