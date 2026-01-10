<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = \App\Models\Classes::active()->get();
        // If query params are present, fetch student list for taking attendance
        $students = [];
        $attendanceData = [];
        $isLocked = false;
        
        if ($request->has('class_id') && $request->has('date')) {
            $classId = $request->class_id;
            $date = $request->date;
            
            // Fetch students in this class
            // TODO: In future precise this with StudentSession for the current academic session
            $students = \App\Models\Student::where('class_id', $classId)->orderBy('name')->get();
            
            // Check if attendance already exists
            $existing = \App\Models\StudentAttendance::where('class_id', $classId)
                        ->where('date', $date)
                        ->get()
                        ->keyBy('student_id');
            
            if ($existing->isNotEmpty()) {
                $attendanceData = $existing;
                $isLocked = $existing->first()->is_locked;
            }
        }

        return view('student-attendance.index', compact('classes', 'students', 'attendanceData', 'isLocked'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:Present,Absent,Late,Half Day,Holiday',
        ]);

        $classId = $request->class_id;
        $date = $request->date;

        // Check lock
        $firstRecord = \App\Models\StudentAttendance::where('class_id', $classId)->where('date', $date)->first();
        if ($firstRecord && $firstRecord->is_locked) {
            return back()->with('error', 'Attendance for this date is locked and cannot be modified.');
        }

        foreach ($request->attendance as $studentId => $status) {
            \App\Models\StudentAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date, // Unique constraint key
                ],
                [
                    'class_id' => $classId,
                    'status' => $status,
                    'remarks' => $request->remarks[$studentId] ?? null,
                    'is_locked' => $request->has('lock_attendance'), // Checkbox from form
                ]
            );
        }

        return redirect()->route('student-attendance.index', ['class_id' => $classId, 'date' => $date])
            ->with('success', 'Attendance saved successfully.');
    }
    
    public function report(Request $request)
    {
        $classes = \App\Models\Classes::active()->get();
        $reportData = [];
        $summary = [];

        if ($request->has('class_id') && $request->has('month')) {
            $classId = $request->class_id;
            $month = $request->month; // YYYY-MM
            
            $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($month)->endOfMonth();
            
            // Get all students
            $students = \App\Models\Student::where('class_id', $classId)->orderBy('name')->get();
            
            // Get all attendance for this month
            $attendances = \App\Models\StudentAttendance::where('class_id', $classId)
                            ->whereBetween('date', [$startDate, $endDate])
                            ->get()
                            ->groupBy('student_id');

            foreach ($students as $student) {
                $studentAtt = $attendances->get($student->id, collect());
                $totalDays = $studentAtt->count();
                $presentDays = $studentAtt->where('status', 'Present')->count();
                $percentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;
                
                $summary[$student->id] = [
                    'student' => $student,
                    'present' => $presentDays,
                    'total' => $totalDays,
                    'percentage' => $percentage,
                    'details' => $studentAtt->keyBy('date'), // Key by full date string for easy lookup in view
                ];
            }
        }

        return view('student-attendance.report', compact('classes', 'summary'));
    }
}
