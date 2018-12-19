<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
        return [
            'site_title'    => 'required',
            'address'       => 'required',
            'contact_no'    => 'required|numeric',
            'email_id'      => 'required'
        ];

    }
    public function messages()
    {
        return [
            'site_title.required'   => 'Please enter site title.',
            'address.required'      => 'Please enter site address.',
            'address.required'      => 'Please enter contact number.',
            'email_id.required'     => 'Please enter email Id.'
        ];
    }
}
