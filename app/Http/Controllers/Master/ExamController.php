<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ExamStoreRequest;
use App\Services\ExamService;
use App\Models\Exam;
use App\Models\AcademicSession;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->examService->getDataTable();
        }
        return view('master.exams.index');
    }

    public function create()
    {
        $formData = $this->examService->getFormData();
        return view('master.exams.create', $formData);
    }

    public function store(ExamStoreRequest $request)
    {
        $this->examService->createExam($request->validated());
        return redirect()->route('master.exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        $formData = $this->examService->getFormData();
        return view('master.exams.edit', array_merge(compact('exam'), $formData));
    }

    public function update(ExamStoreRequest $request, Exam $exam)
    {
        $this->examService->updateExam($exam, $request->validated());
        return redirect()->route('master.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $this->examService->deleteExam($exam);
        return redirect()->route('master.exams.index')->with('success', 'Exam deleted successfully.');
    }
}
