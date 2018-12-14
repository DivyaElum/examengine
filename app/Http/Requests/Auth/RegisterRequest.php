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
        $strUserRoles = $this->request->get('user_role');

        if($strUserRoles == 'candidate'){
            return [
                'first_name'            => 'required',
                'last_name'             => 'required',
                'password'              => 'required|min:8|max:20',
                'confirm_password'      => 'required|same:password|min:8|max:20',
                'email'                 => 'required|email|unique:users',
                'telephone_no'          => 'required|numeric'
            ];
        }else{
            return [
                'first_name'            => 'required',
                'last_name'             => 'required',
                'password'              => 'required|min:8|max:20',
                'confirm_password'      => 'required|same:password|min:8|max:20',
                'email'                 => 'required|email|unique:users',
                'telephone_no'          => 'required|numeric',
                'organisation_name'     => 'required',
                'organisation_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=250,min_height=250|dimensions:min_width=250,max_width=250'
            ];
        }
         
    }
    public function messages()
    {
        return [
            'first_name.required'         => 'Please enter first name.',
            'last_name.required'          => 'Please enter last name.',
            'password.required'           => 'Please enter password.',
            'password.min'                => 'Please enter atleast 8 digit password',
            'confirm_password.max'        => 'Please enter no more than 20 characters.',
            'confirm_password.required'   => 'Please enter Confirm password',
            'confirm_password.same'       => 'Confirm Password does not match.',
            'email.required'              => 'Email Id field is required.',
            'email.unique'                => 'Please comform this email Id already exits.',
            'telephone_no.required'       => 'Phone number field is required.',
            'telephone_no.numeric'        => 'The phone number format is invalid',
            'organisation_name.required'  => 'Please enter organisation name',
            'organisation_image.required' => 'Please upload organisation logo image',
            'organisation_image.dimensions' => 'Please upload valid organisation logo image size'
        ];
    }
}
