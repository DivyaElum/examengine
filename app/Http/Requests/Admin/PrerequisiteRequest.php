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
        $id = base64_decode(base64_decode($this->route('prerequisite'))) ?? null;

        if (empty($id)) 
        {
            return [
                
                'title'        => 'required|min:1|unique:prerequisite,title,'.$id,
                'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4|max:2048',
                'pdf_file'     => 'mimes:pdf|max:2048',
                'youtube_url'  => 'nullable|url',
                'video_url'    => 'nullable|url',

            ];
        }
        else
        {
            if (!empty($this->old_video_file)) 
            {
                return [
                    'title'        => 'required|min:1|unique:prerequisite,title,'.$id,
                ];
            }
            else
            {
                return [
                
                    'title'        => 'required|min:1|unique:prerequisite,title,'.$id,
                    'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4|max:2048',
                    'pdf_file'     => 'mimes:pdf|max:2048',
                    'youtube_url'  => 'nullable|url',
                    'video_url'    => 'nullable|url',
                ];
            }
        }
    }

    public function messages()
    {
        return [
            'title.required'  => 'Title field is required.',
            'video_file.size' => 'Video file size must be less than 2 MB'
        ];
    }
}
