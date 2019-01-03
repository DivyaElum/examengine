<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookExamSlotModel extends Model
{
    protected $table = 'book_exam_slots';

    protected $fillable = ['user_id', 'course_id', 'exam_id', 'pass', 'slot_time', 'slot_date', 'booking_attempt'];
}
