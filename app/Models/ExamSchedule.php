<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'exam_id',
        'class_id',
        'course_id',
        'date',
        'start_time',
        'end_time',
        'full_marks',
        'pass_marks',
        'room_no',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function marks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
