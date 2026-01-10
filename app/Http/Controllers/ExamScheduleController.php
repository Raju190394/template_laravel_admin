<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ExamScheduleStoreRequest;
use App\Services\ExamScheduleService;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Course;

class ExamScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ExamScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(Exam $exam)
    {
        $formData = $this->scheduleService->getFormData($exam);
        $schedules = $this->scheduleService->getSchedules($exam);
        
        return view('master.exams.schedule', array_merge($formData, compact('schedules')));
    }

    public function store(ExamScheduleStoreRequest $request, Exam $exam)
    {
        try {
            $this->scheduleService->createSchedule($exam, $request->validated());
            return redirect()->route('exams.schedules.index', $exam->id)->with('success', 'Exam scheduled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
