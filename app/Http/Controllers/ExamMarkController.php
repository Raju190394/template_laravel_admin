<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ExamMarkStoreRequest;
use App\Services\ExamMarkService;
use App\Models\ExamSchedule;

class ExamMarkController extends Controller
{
    protected $markService;

    public function __construct(ExamMarkService $markService)
    {
        $this->markService = $markService;
    }

    public function index(ExamSchedule $exam_schedule)
    {
        $exam_schedule->load(['exam', 'class', 'course', 'marks']);
        $data = $this->markService->getStudentsAndMarks($exam_schedule);
        
        return view('master.exams.marks', array_merge(['exam_schedule' => $exam_schedule], $data));
    }

    public function store(ExamMarkStoreRequest $request, ExamSchedule $exam_schedule)
    {
        $this->markService->updateMarks($exam_schedule, $request->validated());
        return redirect()->route('exams.marks.index', $exam_schedule->id)->with('success', 'Marks updated successfully.');
    }
}
