<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TimeTableStoreRequest;
use App\Services\TimeTableService;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Staff;

class TimeTableController extends Controller
{
    protected $timeTableService;

    public function __construct(TimeTableService $timeTableService)
    {
        $this->timeTableService = $timeTableService;
    }

    public function index(Request $request)
    {
        $classes = Classes::all();
        $selected_class_id = $request->class_id;
        $class = null;
        $timetables = [];

        if ($selected_class_id) {
            $class = Classes::find($selected_class_id);
            if ($class) {
                $timetables = $this->timeTableService->getTimeTablesByClass($selected_class_id);
            }
        }

        $courses = Course::all();
        $staffs = Staff::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('timetable.index', compact('classes', 'selected_class_id', 'class', 'timetables', 'courses', 'staffs', 'days'));
    }

    public function store(TimeTableStoreRequest $request)
    {
        try {
            $this->timeTableService->createTimeTable($request->validated());
            return redirect()->route('timetable.index', ['class_id' => $request->class_id])->with('success', 'Class Routine added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $class_id = $this->timeTableService->deleteTimeTable($id);
        return redirect()->route('timetable.index', ['class_id' => $class_id])->with('success', 'Entry deleted.');
    }
}
