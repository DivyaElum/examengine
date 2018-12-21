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
                
                'title'        => 'required|unique:prerequisite,title,'.$id,
                'status'       => 'required',
                'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                'pdf_file'     => 'mimes:pdf',
            ];
        }
        else
        {
            if (!empty($this->old_video_file)) 
            {
                return [
                    'title'        => 'required|unique:prerequisite,title,'.$id,
                    'status'       => 'required',
                ];
            }
            else
            {
                return [
                
                    'title'        => 'required|unique:prerequisite,title,'.$id,
                    'status'       => 'required',
                    'video_file'   => 'mimes:mpg,mpeg,avi,wmv,mov,rm,ram,swf,flv,ogg,webm,mp4',
                    'pdf_file'     => 'mimes:pdf',
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
