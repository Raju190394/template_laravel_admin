<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use App\Models\Classes;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->studentService->getDataTable();
        }
        return view('students.index');
    }

    public function create()
    {
        $formData = $this->studentService->getFormData();
        return view('students.create', $formData);
    }

    public function store(StudentStoreRequest $request)
    {
        $this->studentService->createStudent($request->all());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $formData = $this->studentService->getFormData();
        return view('students.edit', array_merge(compact('student'), $formData));
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        $this->studentService->updateStudent($student, $request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->studentService->deleteStudent($student);

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
