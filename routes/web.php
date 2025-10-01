<?php

use Illuminate\Support\Facades\Route;

// --- Controllers ---
// Admin
use App\Http\Controllers\Admin\SessionDashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController; // <-- เปลี่ยนชื่อตอน import
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SessionCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ReportController;

// Frontend
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramsController; // <-- เราจะใช้ตัวนี้เป็นหลักสำหรับ Frontend Program
use App\Http\Controllers\PublicSessionController; // สำหรับหน้ารายละเอียด Session
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;

// Auth (OTP Reset Password)
use App\Http\Controllers\Auth\PasswordResetController;


// =======================================================
// ===               PUBLIC ROUTES                     ===
// =======================================================

// หน้าแรก
Route::get('/', [HomeController::class, 'index'])->name('home');

// หน้ารวมหลักสูตรทั้งหมด
Route::get('/programs', [ProgramsController::class, 'index'])->name('programs.index'); // <-- เปลี่ยนชื่อเป็น programs.index

// หน้ารายละเอียดหลักสูตร
Route::get('/programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');

// หน้ารายละเอียด Session (ถ้ามี)
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');

// หน้าตรวจสอบ Certificate
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');


// =======================================================
// ===           AUTHENTICATED USER ROUTES             ===
// =======================================================
Route::middleware('auth')->group(function () {

    // Dashboard redirect
    Route::get('/dashboard', fn() => redirect()->route('profile.edit'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');

    // Registration
    Route::post('/sessions/{session}/register', [RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [RegistrationController::class, 'destroy'])->name('registrations.cancel');
    Route::get('/programs/{id}/register', [ProgramsController::class, 'register'])->name('programs.register'); // <-- ย้ายเข้ามาในกลุ่ม auth

    // Feedback
    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Certificates
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
});


// =======================================================
// ===                 ADMIN ROUTES                    ===
// =======================================================
Route::middleware(['auth', 'is.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('programs', AdminProgramController::class); // <-- ใช้ Controller ที่เปลี่ยนชื่อ
        Route::resource('trainers', TrainerController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('levels', LevelController::class);

        Route::resource('programs.sessions', SessionController::class);

        Route::get('/attendance', [AttendanceController::class, 'overview'])->name('attendance.overview');
        Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

        Route::post('/sessions/{session}/complete', [SessionCompletionController::class, 'complete'])->name('sessions.complete');

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/feedback', [ReportController::class, 'feedbackIndex'])->name('feedback.index');
            Route::get('/feedback/{session}', [ReportController::class, 'feedbackDetails'])->name('feedback.details');
            Route::get('/feedback/{session}/export', [ReportController::class, 'exportFeedback'])->name('feedback.export');
        });
    });

// =======================================================
// ===                 AUTH ROUTES                     ===
// =======================================================

// --- Password Reset with OTP ---
Route::get('/password/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify.code');
Route::get('/password/reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/update-with-code', [PasswordResetController::class, 'updatePassword'])->name('password.update.with.code');

// --- Include Breeze's Auth Routes ---
require __DIR__.'/auth.php';