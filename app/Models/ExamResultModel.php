<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseModel;
use App\User;

class ExamResultModel extends Model
{
	protected $table = 'exam_results';

	protected $fillable = ['user_id', 'course_id', 'exam_id', 'exam_status'];

	public function course()
	{	
		return $this->belongsTo(CourseModel::class, 'course_id', 'id');
	}

	public function user()
	{	
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
