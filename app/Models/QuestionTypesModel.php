<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\QuestionTypeStructureModel;

class QuestionTypesModel extends Model
{
	use SoftDeletes;

	protected $table = 'question_types'; 

    protected $dates = ['deleted_at'];
}
