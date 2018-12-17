<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class resetPasswordRequest extends FormRequest
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
            'password'              => 'required|min:8|max:20',
            'confirm_password'      => 'required|same:password|min:8|max:20'
        ];

    }
    public function messages()
    {
        return [
            'password.required'         => 'Please enter password.',
            'password.min'              => 'Please enter atleast 8 digit password',
            'confirm_password.max'      => 'Please enter no more than 20 characters.',
            'confirm_password.required' => 'Please enter Confirm password',
            'confirm_password.same'     => 'Confirm Password does not match.',
        ];
    }
}
