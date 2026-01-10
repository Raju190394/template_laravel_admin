<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StudentPromotionRequest;
use App\Services\StudentPromotionService;
use App\Models\AcademicSession;
use App\Models\Classes;
use App\Models\Student;

class StudentPromotionController extends Controller
{
    protected $promotionService;

    public function __construct(StudentPromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index(Request $request)
    {
        $formData = $this->promotionService->getFormData();

        $students = [];
        if ($request->has('class_id') && $request->has('session_id')) {
            $students = $this->promotionService->getStudentsForPromotion(
                $request->class_id,
                $request->session_id
            );
        }

        return view('master.promotion.index', array_merge($formData, compact('students')));
    }

    public function promote(StudentPromotionRequest $request)
    {
        $promotedCount = $this->promotionService->promoteStudents($request->validated());

        return redirect()->route('master.promotion.index')
            ->with('success', "Successfully promoted $promotedCount students.");
    }
}
