<?php

namespace App\Http\Requests\Admin;

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
            'txtNewPassword'     => 'required|min:8|max:20',
            'txtComPassword'     => 'required|same:txtNewPassword|min:8|max:20'
        ];

    }
    public function messages()
    {
        return [
            'txtNewPassword.required'   => 'Please enter password.',
            'txtNewPassword.min'        => 'Please enter atleast 8 digit password',
            'txtComPassword.max'        => 'Please enter no more than 20 characters.',
            'txtComPassword.required'   => 'Please enter Confirm password',
            'txtComPassword.same'       => 'Confirm Password does not match.',
        ];
    }
}
