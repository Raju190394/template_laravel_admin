<?php

namespace App\Services;

use App\Models\Student;
use App\Models\SchoolSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CertificateService
{
    protected $schoolSettings;

    public function __construct()
    {
        $this->schoolSettings = SchoolSetting::first();
    }

    /**
     * Get data needed for certificate generation forms
     */
    public function getFormData()
    {
        return [
            'students' => Student::with('class')->orderBy('name')->get(),
            'exams' => \App\Models\Exam::latest()->get(),
        ];
    }

    /**
     * Generate Student ID Card
     */
    public function generateIdCard(Student $student)
    {
        $student->load('class');
        
        $data = [
            'student' => $student,
            'school' => $this->schoolSettings,
            'academic_year' => $this->getCurrentAcademicYear(),
        ];

        $pdf = Pdf::loadView('certificates.id-card', $data);
        $pdf->setPaper([0, 0, 243, 153], 'landscape'); // ID card size (85.6mm x 54mm)
        
        return $pdf;
    }

    /**
     * Generate Transfer Certificate
     */
    public function generateTransferCertificate(Student $student, array $additionalData = [])
    {
        $student->load('class');
        
        $data = array_merge([
            'student' => $student,
            'school' => $this->schoolSettings,
            'issue_date' => Carbon::now()->format('d-m-Y'),
            'tc_number' => $this->generateTCNumber(),
            'reason' => $additionalData['reason'] ?? 'On request of parents',
            'conduct' => $additionalData['conduct'] ?? 'Good',
            'last_attendance_date' => $additionalData['last_attendance_date'] ?? Carbon::now()->format('d-m-Y'),
        ], $additionalData);

        $pdf = Pdf::loadView('certificates.transfer-certificate', $data);
        $pdf->setPaper('a4');
        
        return $pdf;
    }

    /**
     * Generate Bonafide Certificate
     */
    public function generateBonafideCertificate(Student $student, array $additionalData = [])
    {
        $student->load('class');
        
        $data = array_merge([
            'student' => $student,
            'school' => $this->schoolSettings,
            'issue_date' => Carbon::now()->format('d-m-Y'),
            'certificate_number' => $this->generateCertificateNumber('BC'),
            'purpose' => $additionalData['purpose'] ?? 'For general purposes',
        ], $additionalData);

        $pdf = Pdf::loadView('certificates.bonafide-certificate', $data);
        $pdf->setPaper('a4');
        
        return $pdf;
    }

    /**
     * Generate Character Certificate
     */
    public function generateCharacterCertificate(Student $student, array $additionalData = [])
    {
        $student->load('class');
        
        $data = array_merge([
            'student' => $student,
            'school' => $this->schoolSettings,
            'issue_date' => Carbon::now()->format('d-m-Y'),
            'certificate_number' => $this->generateCertificateNumber('CC'),
            'character_remarks' => $additionalData['character_remarks'] ?? 'Good moral character and conduct',
        ], $additionalData);

        $pdf = Pdf::loadView('certificates.character-certificate', $data);
        $pdf->setPaper('a4');
        
        return $pdf;
    }

    /**
     * Generate Mark Sheet / Report Card
     */
    public function generateMarkSheet(Student $student, $examId)
    {
        $student->load(['class', 'examMarks' => function($query) use ($examId) {
            $query->whereHas('examSchedule', function($q) use ($examId) {
                $q->where('exam_id', $examId);
            })->with(['examSchedule.course', 'examSchedule.exam']);
        }]);

        $marks = $student->examMarks;
        $totalMarks = $marks->sum('examSchedule.full_marks');
        $obtainedMarks = $marks->sum('marks_obtained');
        $percentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 2) : 0;
        
        $data = [
            'student' => $student,
            'school' => $this->schoolSettings,
            'marks' => $marks,
            'total_marks' => $totalMarks,
            'obtained_marks' => $obtainedMarks,
            'percentage' => $percentage,
            'grade' => $this->calculateGrade($percentage),
            'result' => $this->determineResult($marks),
            'issue_date' => Carbon::now()->format('d-m-Y'),
        ];

        $pdf = Pdf::loadView('certificates.mark-sheet', $data);
        $pdf->setPaper('a4');
        
        return $pdf;
    }

    /**
     * Bulk Generate Certificates
     */
    public function bulkGenerate($studentIds, $certificateType, $additionalData = [])
    {
        $students = Student::whereIn('id', $studentIds)->get();
        $pdfs = [];

        foreach ($students as $student) {
            switch ($certificateType) {
                case 'id_card':
                    $pdfs[] = $this->generateIdCard($student);
                    break;
                case 'transfer':
                    $pdfs[] = $this->generateTransferCertificate($student, $additionalData);
                    break;
                case 'bonafide':
                    $pdfs[] = $this->generateBonafideCertificate($student, $additionalData);
                    break;
                case 'character':
                    $pdfs[] = $this->generateCharacterCertificate($student, $additionalData);
                    break;
            }
        }

        return $pdfs;
    }

    /**
     * Helper: Generate TC Number
     */
    protected function generateTCNumber()
    {
        return 'TC-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Helper: Generate Certificate Number
     */
    protected function generateCertificateNumber($prefix)
    {
        return $prefix . '-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Helper: Get Current Academic Year
     */
    protected function getCurrentAcademicYear()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        return $currentYear . '-' . $nextYear;
    }

    /**
     * Helper: Calculate Grade
     */
    protected function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }

    /**
     * Helper: Determine Result
     */
    protected function determineResult($marks)
    {
        foreach ($marks as $mark) {
            if ($mark->marks_obtained < $mark->examSchedule->pass_marks) {
                return 'FAIL';
            }
        }
        return 'PASS';
    }
}
