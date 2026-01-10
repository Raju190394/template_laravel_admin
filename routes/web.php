<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
// Master Module Controllers
use App\Http\Controllers\Master\SchoolSettingController;
use App\Http\Controllers\Master\ClassesController;
use App\Http\Controllers\Master\FeeStructureController;
use App\Http\Controllers\Master\CourseController as MasterCourseController;
use App\Http\Controllers\Fees\FeePaymentController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management
    Route::resource('users', UserController::class);
    
    // Student Management
    Route::resource('students', StudentController::class);
    
    // Master Module Routes
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('school-settings', SchoolSettingController::class);
        Route::resource('classes', ClassesController::class);
        Route::resource('fee-structures', FeeStructureController::class);
        Route::resource('courses', MasterCourseController::class);
        Route::resource('academic-sessions', \App\Http\Controllers\Master\AcademicSessionController::class);
        Route::resource('exams', \App\Http\Controllers\Master\ExamController::class);
        
        Route::get('promotion', [\App\Http\Controllers\Master\StudentPromotionController::class, 'index'])->name('promotion.index');
        Route::post('promotion', [\App\Http\Controllers\Master\StudentPromotionController::class, 'promote'])->name('promotion.store');
        Route::resource('notices', \App\Http\Controllers\Master\NoticeController::class);
    });

    // Exams & Marks Module
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('reports', [\App\Http\Controllers\ReportCardController::class, 'index'])->name('reports.index');
        Route::post('reports', [\App\Http\Controllers\ReportCardController::class, 'generate'])->name('reports.generate');

        Route::get('{exam}/schedules', [\App\Http\Controllers\ExamScheduleController::class, 'index'])->name('schedules.index');
        Route::post('{exam}/schedules', [\App\Http\Controllers\ExamScheduleController::class, 'store'])->name('schedules.store');
        
        Route::get('{exam_schedule}/marks', [\App\Http\Controllers\ExamMarkController::class, 'index'])->name('marks.index');
        Route::post('{exam_schedule}/marks', [\App\Http\Controllers\ExamMarkController::class, 'store'])->name('marks.store');
    });

    // Time Table Module
    Route::resource('timetable', \App\Http\Controllers\TimeTableController::class)->except(['create', 'edit', 'show', 'update']);

    // Fees Module Routes
    Route::prefix('fees')->name('fees.')->group(function () {
        Route::get('payments/get-student-fees/{student}', [FeePaymentController::class, 'getStudentFees'])->name('payments.getFees');
        Route::get('payments/{payment}/pdf', [FeePaymentController::class, 'downloadPDF'])->name('payments.pdf');
        Route::resource('payments', FeePaymentController::class);
    });

    // Staff & Attendance Module
    Route::resource('staff', \App\Http\Controllers\StaffController::class);
    Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/mark', [\App\Http\Controllers\AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::post('attendance/mark', [\App\Http\Controllers\AttendanceController::class, 'storeMark'])->name('attendance.storeMark');
    
    // Student Attendance
    Route::prefix('student-attendance')->name('student-attendance.')->group(function () {
        Route::get('/', [\App\Http\Controllers\StudentAttendanceController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\StudentAttendanceController::class, 'store'])->name('store');
        Route::get('/report', [\App\Http\Controllers\StudentAttendanceController::class, 'report'])->name('report');
    });

    // Mailbox Module
    Route::prefix('mailbox')->name('mailbox.')->group(function () {
        Route::get('/', [\App\Http\Controllers\MailboxController::class, 'index'])->name('index');
        Route::get('/unread-data', [\App\Http\Controllers\MailboxController::class, 'getUnreadData'])->name('unread-data');
        Route::get('/sent', [\App\Http\Controllers\MailboxController::class, 'sent'])->name('sent');
        Route::get('/archived', [\App\Http\Controllers\MailboxController::class, 'archived'])->name('archived');
        Route::post('/mass-delete', [\App\Http\Controllers\MailboxController::class, 'massDestroy'])->name('mass-destroy');
        Route::post('/mass-archive', [\App\Http\Controllers\MailboxController::class, 'massArchive'])->name('mass-archive');
        Route::get('/compose', [\App\Http\Controllers\MailboxController::class, 'create'])->name('compose');
        Route::post('/send', [\App\Http\Controllers\MailboxController::class, 'store'])->name('store');
        Route::get('/{message}', [\App\Http\Controllers\MailboxController::class, 'show'])->name('show');
        Route::delete('/{message}', [\App\Http\Controllers\MailboxController::class, 'destroy'])->name('destroy');
        Route::patch('/{message}/archive', [\App\Http\Controllers\MailboxController::class, 'archive'])->name('archive');
    });

    // Library Module
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/books', [\App\Http\Controllers\LibraryController::class, 'booksIndex'])->name('books.index');
        Route::post('/books', [\App\Http\Controllers\LibraryController::class, 'booksStore'])->name('books.store');
        Route::get('/issues', [\App\Http\Controllers\LibraryController::class, 'issuesIndex'])->name('issues.index');
        Route::post('/issues', [\App\Http\Controllers\LibraryController::class, 'issuesStore'])->name('issues.store');
        Route::post('/issues/{issue}/return', [\App\Http\Controllers\LibraryController::class, 'returnBook'])->name('issues.return');
    });

    // Certificate Generation Routes
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CertificateController::class, 'index'])->name('index');
        Route::get('/id-card/{student}', [\App\Http\Controllers\CertificateController::class, 'generateIdCard'])->name('id-card');
        Route::post('/transfer/{student}', [\App\Http\Controllers\CertificateController::class, 'generateTransferCertificate'])->name('transfer');
        Route::post('/bonafide/{student}', [\App\Http\Controllers\CertificateController::class, 'generateBonafideCertificate'])->name('bonafide');
        Route::post('/character/{student}', [\App\Http\Controllers\CertificateController::class, 'generateCharacterCertificate'])->name('character');
        Route::get('/marksheet/{student}/{exam}', [\App\Http\Controllers\CertificateController::class, 'generateMarkSheet'])->name('marksheet');
        Route::post('/bulk-generate', [\App\Http\Controllers\CertificateController::class, 'bulkGenerate'])->name('bulk-generate');
        Route::get('/preview', [\App\Http\Controllers\CertificateController::class, 'preview'])->name('preview');
    });

    // Parent Portal Routes
    Route::middleware(['auth', \App\Http\Middleware\ParentMiddleware::class])->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ParentPortalController::class, 'index'])->name('dashboard');
        Route::get('/student/{student}', [\App\Http\Controllers\ParentPortalController::class, 'studentDashboard'])->name('student.view');
        Route::get('/student/{student}/attendance', [\App\Http\Controllers\ParentPortalController::class, 'attendance'])->name('student.attendance');
        Route::get('/student/{student}/fees', [\App\Http\Controllers\ParentPortalController::class, 'fees'])->name('student.fees');
        Route::get('/student/{student}/results', [\App\Http\Controllers\ParentPortalController::class, 'results'])->name('student.results');
    });
});

require __DIR__.'/auth.php';

require __DIR__.'/debug_counts.php';
