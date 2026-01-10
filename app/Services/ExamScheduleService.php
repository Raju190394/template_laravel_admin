<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamSchedule;

class ExamScheduleService
{
    public function getFormData(Exam $exam)
    {
        $exam->load(['academicSession']);
        return [
            'exam' => $exam,
            'classes' => \App\Models\Classes::all(),
            'courses' => \App\Models\Course::all(),
        ];
    }

    public function getSchedules(Exam $exam)
    {
        return $exam->schedules()->with(['class', 'course'])->orderBy('date')->get();
    }

    public function createSchedule(Exam $exam, array $data)
    {
        $exists = ExamSchedule::where('exam_id', $exam->id)
            ->where('class_id', $data['class_id'])
            ->where('course_id', $data['course_id'])
            ->exists();
            
        if ($exists) {
            throw new \Exception('This subject is already scheduled for this class in this exam.');
        }

        return ExamSchedule::create(array_merge($data, ['exam_id' => $exam->id]));
    }
}
