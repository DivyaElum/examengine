<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\ExamQuestionsModel;
use App\Models\TransactionModel;
// use App\Models\ExamSlotModel;

class CourseModel extends Model
{
	use SoftDeletes;
	
	protected $table = 'course';

	// public function slots()
	// {
	// 	return $this->hasMany(ExamSlotModel::class, 'exam_id', 'id');
	// }

	// public function questions()
	// {
	// 	return $this->hasMany(ExamQuestionsModel::class, 'exam_id', 'id');
	// }

	public function transaction()
	{
		return $this->belongsTo(TransactionModel::class, 'id', 'course_id');
	}

    // public function getPrerequisiteIdAttribute($value)
    // {
    //     return json_decode($value);
    // }
}	

