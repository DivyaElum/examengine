<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategoryModel extends Model
{
    protected $table = 'question_category'; 

    protected $dates = ['deleted_at'];
}
