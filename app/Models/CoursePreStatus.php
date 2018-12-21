<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePreStatus extends Model
{
    protected $table = 'course_pre_status';

    protected $fillable = [
    	'user_id','course_id','prerequisite_id','watch_time','duration'
   	];
}
