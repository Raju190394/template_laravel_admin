<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Show certificate generation page
     */
    public function index()
    {
        $formData = $this->certificateService->getFormData();
        return view('certificates.index', $formData);
    }

    /**
     * Generate ID Card
     */
    public function generateIdCard($studentId)
    {
        $student = Student::findOrFail($studentId);
        $pdf = $this->certificateService->generateIdCard($student);
        
        return $pdf->download('id-card-' . $student->name . '.pdf');
    }

    /**
     * Generate Transfer Certificate
     */
    public function generateTransferCertificate(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        
        $additionalData = $request->only([
            'reason',
            'conduct',
            'last_attendance_date'
        ]);
        
        $pdf = $this->certificateService->generateTransferCertificate($student, $additionalData);
        
        return $pdf->download('transfer-certificate-' . $student->name . '.pdf');
    }

    /**
     * Generate Bonafide Certificate
     */
    public function generateBonafideCertificate(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        
        $additionalData = $request->only(['purpose']);
        
        $pdf = $this->certificateService->generateBonafideCertificate($student, $additionalData);
        
        return $pdf->download('bonafide-certificate-' . $student->name . '.pdf');
    }

    /**
     * Generate Character Certificate
     */
    public function generateCharacterCertificate(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        
        $additionalData = $request->only(['character_remarks']);
        
        $pdf = $this->certificateService->generateCharacterCertificate($student, $additionalData);
        
        return $pdf->download('character-certificate-' . $student->name . '.pdf');
    }

    /**
     * Generate Mark Sheet
     */
    public function generateMarkSheet($studentId, $examId)
    {
        $student = Student::findOrFail($studentId);
        $pdf = $this->certificateService->generateMarkSheet($student, $examId);
        
        return $pdf->download('mark-sheet-' . $student->name . '.pdf');
    }

    /**
     * Bulk Generate Certificates
     */
    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'certificate_type' => 'required|in:id_card,transfer,bonafide,character',
        ]);

        $pdfs = $this->certificateService->bulkGenerate(
            $request->student_ids,
            $request->certificate_type,
            $request->all()
        );

        // For bulk, we'll zip them or return the first one
        // For simplicity, returning success message
        return back()->with('success', 'Certificates generated successfully for ' . count($pdfs) . ' students.');
    }

    /**
     * Preview Certificate
     */
    public function preview(Request $request)
    {
        $type = $request->get('type');
        $studentId = $request->get('student_id');
        $student = Student::findOrFail($studentId);

        switch ($type) {
            case 'id_card':
                $pdf = $this->certificateService->generateIdCard($student);
                break;
            case 'transfer':
                $pdf = $this->certificateService->generateTransferCertificate($student);
                break;
            case 'bonafide':
                $pdf = $this->certificateService->generateBonafideCertificate($student);
                break;
            case 'character':
                $pdf = $this->certificateService->generateCharacterCertificate($student);
                break;
            default:
                abort(404);
        }

        return $pdf->stream();
    }
}
