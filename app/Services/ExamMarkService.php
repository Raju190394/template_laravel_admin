<?php

namespace App\Services;

use App\Models\ExamSchedule;
use App\Models\ExamMark;
use App\Models\Student;

class ExamMarkService
{
    public function getStudentsAndMarks(ExamSchedule $exam_schedule)
    {
        $students = Student::where('class_id', $exam_schedule->class_id)
            ->orderBy('name')
            ->get();
            
        $existingMarks = $exam_schedule->marks->keyBy('student_id');

        return compact('students', 'existingMarks');
    }

    public function updateMarks(ExamSchedule $exam_schedule, array $data)
    {
        foreach ($data['marks'] as $studentId => $mark) {
            $isAbsent = isset($data['absent'][$studentId]);
            $remarks = $data['remarks'][$studentId] ?? null;

            ExamMark::updateOrCreate(
                [
                    'exam_schedule_id' => $exam_schedule->id,
                    'student_id' => $studentId,
                ],
                [
                    'marks_obtained' => $isAbsent ? 0 : ($mark ?? 0),
                    'is_absent' => $isAbsent,
                    'remarks' => $remarks
                ]
            );
        }
    }
}
