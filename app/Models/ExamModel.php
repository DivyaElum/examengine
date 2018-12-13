<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExamModel extends Model
{
	use SoftDeletes;
	
	protected $table = 'exam';
    //
}


