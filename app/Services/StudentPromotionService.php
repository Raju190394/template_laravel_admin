<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentSession;
use Illuminate\Support\Facades\DB;

class StudentPromotionService
{
    public function getFormData()
    {
        return [
            'sessions' => \App\Models\AcademicSession::latest()->get(),
            'classes' => \App\Models\Classes::all(),
            'currentSession' => \App\Models\AcademicSession::current(),
        ];
    }

    public function getStudentsForPromotion($classId, $sessionId)
    {
        return Student::where('class_id', $classId)
            ->whereDoesntHave('studentSessions', function($q) use ($sessionId) {
                $q->where('academic_session_id', '!=', $sessionId);
            })
            ->get();
    }

    public function promoteStudents(array $data)
    {
        return DB::transaction(function() use ($data) {
            $promotedCount = 0;
            foreach ($data['student_ids'] as $studentId) {
                // 1. Mark current session record as passed/promoted
                StudentSession::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'academic_session_id' => $data['current_session_id'],
                    ],
                    [
                        'class_id' => $data['current_class_id'],
                        'status' => 'promoted',
                    ]
                );

                // 2. Create new session record
                StudentSession::firstOrCreate(
                    [
                        'student_id' => $studentId,
                        'academic_session_id' => $data['target_session_id'],
                    ],
                    [
                        'class_id' => $data['target_class_id'],
                        'status' => 'studying',
                    ]
                );

                // 3. Update student current class
                Student::where('id', $studentId)->update([
                    'class_id' => $data['target_class_id']
                ]);

                $promotedCount++;
            }
            return $promotedCount;
        });
    }
}
