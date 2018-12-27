<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\QuestionsModel;
use App\Models\QuestionCategoryModel;

class ExamQuestionsModel extends Model
{
	// use SoftDeletes;
	
	protected $table = 'exam_questions';

	public function repository()
	{
		return $this->belongsTo(QuestionsModel::class, 'question_id', 'id');
	}

	public function category()
    {
    	return $this->belongsTo(QuestionCategoryModel::class, 'category_id', 'id');
    }
}


