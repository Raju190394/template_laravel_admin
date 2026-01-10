<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\FeePaymentStoreRequest;
use App\Models\FeePayment;
use App\Models\Student;
use App\Services\FeeService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FeePaymentController extends Controller
{
    protected $feeService;

    public function __construct(FeeService $feeService)
    {
        $this->feeService = $feeService;
    }

    public function index()
    {
        $payments = FeePayment::with(['student', 'feeStructure'])->latest()->paginate(20);
        return view('fees.payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('fees.payments.create', compact('students'));
    }

    public function getStudentFees(Student $student)
    {
        $fees = $this->feeService->getStudentFeeStructures($student);
        return response()->json(['fees' => $fees]);
    }

    public function store(FeePaymentStoreRequest $request)
    {
        $payment = $this->feeService->recordPayment($request->validated());

        return redirect()->route('fees.payments.index')
            ->with('success', 'Fee payment recorded successfully. Receipt No: ' . $payment->receipt_no);
    }

    public function show($id)
    {
        $feePayment = FeePayment::with(['student.class', 'feeStructure'])->findOrFail($id);
        $school = \App\Models\SchoolSetting::first() ?? new \App\Models\SchoolSetting([
            'school_name' => 'Vrikshansh International School',
            'city' => 'Mumbai'
        ]);
        return view('fees.payments.show', compact('feePayment', 'school'));
    }

    public function downloadPDF($id)
    {
        $feePayment = FeePayment::with(['student.class', 'feeStructure'])->findOrFail($id);
        $school = \App\Models\SchoolSetting::first();
        
        $pdf = Pdf::loadView('fees.payments.pdf', compact('feePayment', 'school'));
        
        return $pdf->download('Receipt-' . $feePayment->receipt_no . '.pdf');
    }
}
