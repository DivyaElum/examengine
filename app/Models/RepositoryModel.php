<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\QuestionTypesModel;

class RepositoryModel extends Model
{
	use SoftDeletes;

	protected $table = 'repository'; 
    
    protected $dates = ['deleted_at'];

    public function questionFormat()
    {
    	return $this->belongsTo(QuestionTypesModel::class, 'question_type', 'slug');
    }
}
