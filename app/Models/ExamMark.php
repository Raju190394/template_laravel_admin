<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    protected $fillable = [
        'exam_schedule_id',
        'student_id',
        'marks_obtained',
        'is_absent',
        'remarks',
    ];

    protected $casts = [
        'is_absent' => 'boolean',
    ];

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
