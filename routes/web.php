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
    });

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
});

require __DIR__.'/auth.php';

require __DIR__.'/debug_counts.php';
