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
        // dd($this->all());

        $id = base64_decode(base64_decode($this->route('course'))) ?? null;

        return [
            'title'             => 'required|min:1|unique:course,title,'.$id,
            'description'       => 'required',           
            
            'prerequisite.*.title'          => 'required',
            'prerequisite.*.video_file'     => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4|max:2048',
            'prerequisite.*.pdf_file'       => 'mimes:pdf|max:2048',
            'prerequisite.*.youtube_url'    => 'nullable|url',
            'prerequisite.*.video_url'      => 'nullable|url',
            'prerequisite.*.other'          => 'nullable',

            'amount'            => 'required|numeric|gt:0',
            'discount'          => 'numeric',
            'calculated_amount' => 'required|numeric|gt:0',

            'start_date'        => 'required',
            'end_date'          => 'required',

            'featured_image'    => 'mimes:jpeg,jpg,png,gif',

        ];
    }

    public function messages()
    {
        return [
            'title.required'              => 'Title field is required.',
            'description.required'        => 'Description field is required.',

            'amount.required'             => 'Course fee field is required.',
            'amount.numeric'              => 'Course fee should be in numbers only.',
            'amount.gt'                   => 'Course fee should be greater than 0.',

            'calculated_amount.required'  => 'Calculated course fee field is required.',
            'calculated_amount.numeric'   => 'Calculated course fee should be in numbers only.',
            'calculated_amount.gt'        => 'Calculated course fee should be greater than 0.',

            'discount.numeric'            => 'Discount should be in numbers only.',

            'status.required'             => 'Status field is required.',

            'start_date.required'         => 'Start date field is required.',
            'end_date.required'           => 'End date field is required.',

            'prerequisite.*.title.required' => 'Prerequisite display name field is required.',
            'prerequisite.*.video_file.max' => 'Prerequisite video file size must be less than 2 MB.',
            'prerequisite.*.video_file.mimes' => 'Prerequisite video must be a file of type: mpg, mpeg, avi, wmv, mov, rm, ram, swf, flv, ogg, webm, mp4.',
            'prerequisite.*.pdf_file.max'   => 'Prerequisite pdf file size must be less than 2 MB.',
            'prerequisite.*.pdf_file.mimes'   => 'Prerequisite pdf must be a file of type: pdf.',
            
            'prerequisite.*.youtube_url.url'   => 'Youtube url format is invalid.',
            'prerequisite.*.video_url.url'   => 'Video url format is invalid.'

        ];
    }
}
