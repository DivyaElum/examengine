<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PrerequisiteModel extends Model
{
	// use SoftDeletes;
	
	protected $table = 'prerequisite';

	protected $fillable = ['course_id', 'title', 'video_file_mime', 'video_file_original_name', 'video_file', 'pdf_file_original_name', 'pdf_file', 'video_url', 'youtube_url', 'other', 'status', 'updated_at', 'created_at'];
}


