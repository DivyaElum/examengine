<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PrerequisiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required',
            'status'        => 'required',
            'video_file'   => 'required_without_all:video_url,youtube_url | mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
            'video_url'    => 'required_without_all:youtube_url,video_file',
            'youtube_url'  => 'required_without_all:video_file,video_url',
        ];
    }

    public function messages()
    {
        return [
            'title.required'  => 'Title field is required.',
            'status.required' => 'Status field is required.',
        ];
    }
}
