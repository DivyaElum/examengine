<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class CouncilMemberRequest extends FormRequest
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

   public function rules()
    {
        $id = base64_decode(base64_decode($this->route('council_member'))) ?? null;
        return [
            'txtName'           => 'required',
            'txtEmail'          => 'required|email|unique:council_members,email,'.$id,
            'txtDescription'    => 'required',
            'txtDesignation'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'txtName.required'          => 'Name field is required.',
            'txtEmail.required'         => 'email field is required.',
            'txtEmail.email'            => 'email is Invalid.',
            'txtEmail.unique'           => 'email Id already exits.',
            'txtDescription.required'   => 'Description field is required.',
            'txtDesignation.required'   => 'Designation field is required.'
        ];
    }
}
