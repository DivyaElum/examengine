<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CourseModel;

class TransactionModel extends Model
{
	protected $table = 'transaction';

	public function course()
    {
        return $this->belongsTo(CourseModel::class, 'id', 'id');
    }
	
}
