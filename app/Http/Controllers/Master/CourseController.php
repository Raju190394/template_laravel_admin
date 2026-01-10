<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->courseService->getDataTable();
        }
        return view('master.courses.index');
    }

    public function create()
    {
        return view('master.courses.create');
    }

    public function store(CourseStoreRequest $request)
    {
        $this->courseService->createCourse($request->validated());

        return redirect()->route('master.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('master.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('master.courses.edit', compact('course'));
    }

    public function update(CourseUpdateRequest $request, Course $course)
    {
        $this->courseService->updateCourse($course, $request->validated());

        return redirect()->route('master.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->courseService->deleteCourse($course);

        return redirect()->route('master.courses.index')->with('success', 'Course deleted successfully.');
    }
}
