<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamModel;

class ExamSlotModel extends Model
{
    protected $table = "exam_slots";

    public function exam()
    {
    	return $this->belongsTo(ExamModel::class, 'exam_id', 'id');
    }
}
