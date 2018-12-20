<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RepositoryModel;

class ExamQuestionsModel extends Model
{
	use SoftDeletes;
	
	protected $table = 'exam_questions';

	public function repository()
	{
		return $this->belongsTo(RepositoryModel::class, 'question_id', 'id');
	}
}


