<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\QuestionTypesModel;
use App\Models\QuestionCategoryModel;

class QuestionsModel extends Model
{
	// use SoftDeletes;

	protected $table = 'questions'; 
    
    protected $fillable = ['category_id','question_text','question_type','option_type','option1','option2','option3','option4','option5','option6','option7','option8','option9','option10','option11','option12','option13','option14','option15','option16','correct_answer','right_marks','chk_negative_mark','negative_mark'];

    protected $dates = ['deleted_at'];

    public function questionFormat()
    {
    	return $this->belongsTo(QuestionTypesModel::class, 'question_type', 'slug');
    }

    public function category()
    {
    	return $this->belongsTo(QuestionCategoryModel::class, 'category_id', 'id');
    }
}
