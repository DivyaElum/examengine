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
                
<<<<<<< HEAD
                'title'        => 'required|unique:prerequisite,title,'.$id,
=======
                'title'        => 'required|min:4|unique:prerequisite,title,'.$id,
                'status'       => 'required',
>>>>>>> c608ecb5209278567fad5905ea46e83366120c80
                'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                'pdf_file'     => 'mimes:pdf',
                'youtube_url'  => 'nullable|url',
                'video_url'    => 'nullable|url',

            ];
        }
        else
        {
            if (!empty($this->old_video_file)) 
            {
                return [
                    'title'        => 'required|unique:prerequisite,title,'.$id,
                ];
            }
            else
            {
                return [
                
                    'title'        => 'required|unique:prerequisite,title,'.$id,
                    'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                    'pdf_file'     => 'mimes:pdf',
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
        ];
    }
}
