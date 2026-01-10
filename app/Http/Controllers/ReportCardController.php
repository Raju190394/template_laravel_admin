<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    public function index()
    {
        $exams = \App\Models\Exam::active()->latest()->get();
        $classes = \App\Models\Classes::all();
        return view('master.exams.report_index', compact('exams', 'classes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $exam = \App\Models\Exam::findOrFail($request->exam_id);
        $class = \App\Models\Classes::findOrFail($request->class_id);

        // Get schedules/subjects
        $schedules = $exam->schedules()->where('class_id', $class->id)->with('course')->get();

        if ($schedules->isEmpty()) {
            return back()->with('error', 'No schedules found for this class and exam.');
        }

        // Get students
        $students = \App\Models\Student::where('class_id', $class->id)->orderBy('name')->get();

        // Get all marks for these schedules
        $marks = \App\Models\ExamMark::whereIn('exam_schedule_id', $schedules->pluck('id'))->get();

        // Structure data: [student_id][course_id] = mark
        $reportData = [];
        foreach ($students as $student) {
            $studentMarks = [];
            $totalObtained = 0;
            $totalFull = 0;

            foreach ($schedules as $schedule) {
                $markRecord = $marks->where('exam_schedule_id', $schedule->id)->where('student_id', $student->id)->first();
                $val = $markRecord ? ($markRecord->is_absent ? 'Abs' : $markRecord->marks_obtained) : '-';
                $studentMarks[$schedule->course_id] = $val;

                if ($markRecord && !$markRecord->is_absent) {
                    $totalObtained += $markRecord->marks_obtained;
                }
                $totalFull += $schedule->full_marks;
            }

            $percentage = $totalFull > 0 ? round(($totalObtained / $totalFull) * 100, 2) : 0;
            
            $reportData[$student->id] = [
                'name' => $student->name,
                'marks' => $studentMarks,
                'total' => $totalObtained,
                'max_total' => $totalFull,
                'percentage' => $percentage
            ];
        }

        return view('master.exams.report_view', compact('exam', 'class', 'schedules', 'reportData'));
    }
}
