<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
           'txtEmail'     => 'required|email',
           'txtPassword'  => 'required'
        ];
    }
    public function messages()
    {
        return [
            'txtEmail.required'      => 'Email field is required.',
            'txtPassword.required'   => 'Password field is required.'
        ];
    }
}
