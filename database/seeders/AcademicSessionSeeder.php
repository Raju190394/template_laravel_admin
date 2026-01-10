<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Academic Sessions
        $sessions = [
            [
                'name' => '2023-2024',
                'start_date' => '2023-04-01',
                'end_date' => '2024-03-31',
                'is_current' => false,
            ],
            [
                'name' => '2024-2025',
                'start_date' => '2024-04-01',
                'end_date' => '2025-03-31',
                'is_current' => true,
            ],
            [
                'name' => '2025-2026',
                'start_date' => '2025-04-01',
                'end_date' => '2026-03-31',
                'is_current' => false,
            ],
        ];

        foreach ($sessions as $sessionData) {
            \App\Models\AcademicSession::firstOrCreate(
                ['name' => $sessionData['name']],
                $sessionData
            );
        }

        // 2. Assign current students to the current session (2024-2025)
        $currentSession = \App\Models\AcademicSession::where('is_current', true)->first();
        $students = \App\Models\Student::all();

        if ($currentSession && $students->count() > 0) {
            foreach ($students as $student) {
                // Determine status - mostly studying, maybe some promoted logic if needed later
                // For now, assume all current students are 'studying' in the current session
                if ($student->class_id) {
                    \App\Models\StudentSession::firstOrCreate(
                        [
                            'student_id' => $student->id,
                            'academic_session_id' => $currentSession->id,
                        ],
                        [
                            'class_id' => $student->class_id,
                            'status' => 'studying',
                        ]
                    );
                }
            }
        }
    }
}
