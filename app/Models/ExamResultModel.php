<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseModel;

class ExamResultModel extends Model
{
	protected $table = 'exam_results';
    //

	public function course()
	{	
		return $this->belongsTo(CourseModel::class, 'course_id', 'id');
	}
}
