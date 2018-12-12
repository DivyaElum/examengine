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
        $id = $this->route('prerequisite') ?? null;

        if ($id == null) 
        {
            return [
                'title'        => 'required',
                'status'       => 'required',
                'video_file'   => 'required_without_all:video_url,youtube_url | mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                'video_url'    => 'required_without_all:video_file,youtube_url',
                'youtube_url'  => 'required_without_all:video_file,video_url,old_video_file',
            ];
        }
        else
        {
            // dd($this->old_video_file);

            if (!empty($this->old_video_file)) 
            {
                return [
                    'title'        => 'required',
                    'status'       => 'required',
                ];
            }
            else
            {
                return [
                    'title'        => 'required',
                    'status'       => 'required',
                    'video_file'   => 'required_without_all:video_url,youtube_url | mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                    'video_url'    => 'required_without_all:video_file,youtube_url',
                    'youtube_url'  => 'required_without_all:video_file,video_url',
                ];
            }
        }
    }

    public function messages()
    {
        return [
            'title.required'  => 'Title field is required.',
            'status.required' => 'Status field is required.',
        ];
    }
}
