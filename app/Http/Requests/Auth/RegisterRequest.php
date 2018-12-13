<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'txtFirstName'       => 'required',
            'txtLastName'        => 'required',
            'txtPassword'        => 'required|min:8|max:20',
            'txtComfirmPassword' => 'required|same:txtPassword|min:8|max:20',
            'email'              => 'required|email|unique:users',
            'txtPhone'           => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'txtFirstName.required'         => 'First Name field is required.',
            'txtLastName.required'          => 'Last Name field is required.',
            'txtPassword.required'          => 'Password field is required.',
            'txtComfirmPassword.required'   => 'Confirm Password field is required.',
            'txtComfirmPassword.same'       => 'Password does not match',
            'email.required'                => 'Email field is required.',
            'email.unique'                  => 'Please enter unique email Id',
            'txtPhone.required'             => 'Phone number field is required.',
            'txtPhone.numeric'              => 'The phone number format is invalid',
        ];
    }
}
