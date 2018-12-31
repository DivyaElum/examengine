<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
        $id = base64_decode(base64_decode($this->route('voucher'))) ?? null;
        
       return [
            'voucher_code'    => 'required|min:1|unique:voucher,voucher_code,'.$id,
            'user_count'      => 'required|min:1',
            'user_type'       => 'required|min:1',
            'discount'        => 'required|min:1',
            'discount_by'     => 'required|min:1',
            'start_date'      => 'required|min:1',
            'end_date'        => 'required|min:1',
        ];

    }
    public function messages()
    {
        return [
            'voucher_code.required'   => 'Please enter voucher code.',
            'user_count.required'     => 'Please enter user count.',
            'user_type.required'      => 'Please select user type.',
            'discount.required'       => 'Please enter discount.',
            'discount_by.required'    => 'Please enter discount by.',
            'start_date.required'     => 'Please select start date',
            'end_date.required'       => 'Please select end date',
        ];
    }
}
