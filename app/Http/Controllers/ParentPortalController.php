<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\FeePayment;
use App\Models\ExamSchedule;
use App\Models\ExamMark;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    public function index()
    {
        $parent = Auth::user();
        $students = $parent->students()->with('class')->get();
        $notices = Notice::where('is_active', true)
            ->whereIn('target', ['All', 'Parents'])
            ->latest()
            ->take(5)
            ->get();

        return view('parent.dashboard', compact('students', 'notices'));
    }

    public function studentDashboard(Student $student)
    {
        $this->authorizeStudent($student);

        $attendance_summary = StudentAttendance::where('student_id', $student->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $fees = FeePayment::where('student_id', $student->id)->latest()->take(5)->get();
        
        // Latest Exam results
        $latest_marks = ExamMark::where('student_id', $student->id)
            ->with(['examSchedule.course', 'examSchedule.exam'])
            ->latest()
            ->take(10)
            ->get();

        return view('parent.student_view', compact('student', 'attendance_summary', 'fees', 'latest_marks'));
    }

    public function attendance(Student $student)
    {
        $this->authorizeStudent($student);
        $attendance = StudentAttendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('parent.attendance', compact('student', 'attendance'));
    }

    public function fees(Student $student)
    {
        $this->authorizeStudent($student);
        $payments = FeePayment::where('student_id', $student->id)
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('parent.fees', compact('student', 'payments'));
    }

    public function results(Student $student)
    {
        $this->authorizeStudent($student);
        $marks = ExamMark::where('student_id', $student->id)
            ->with(['examSchedule.course', 'examSchedule.exam'])
            ->get()
            ->groupBy(function($item) {
                return $item->examSchedule->exam->exam_name;
            });

        return view('parent.results', compact('student', 'marks'));
    }

    private function authorizeStudent(Student $student)
    {
        if ($student->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized access to student data.');
        }
    }
}
