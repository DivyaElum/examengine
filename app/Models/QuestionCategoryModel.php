<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\QuestionsModel;

class QuestionCategoryModel extends Model
{
    protected $table = 'question_category'; 

    protected $dates = ['deleted_at'];

    protected $fillable = ['category_name'];
    
    public function questions()
    {
    	return $this->hasMany(QuestionsModel::class, 'category_id', 'id');
    }
}
