<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ExamQuestionsModel;
use App\Models\ExamSlotModel;

class ExamModel extends Model
{
	use SoftDeletes;
	
	protected $table = 'exam';

	public function slots()
	{
		return $this->hasMany(ExamSlotModel::class, 'exam_id', 'id');
	}

	public function questions()
	{
		return $this->hasMany(ExamQuestionsModel::class, 'exam_id', 'id');
	}
}


