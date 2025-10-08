<?php

use Illuminate\Support\Facades\Route;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\SessionDashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SessionCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\CertificateAdminController;

// --- Frontend Controllers ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;

// --- Auth Controllers ---
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', [HomeController::class, 'index'])->name('home');

// หน้ารวมหลักสูตร
Route::get('/programs', [ProgramsController::class, 'index'])->name('programs.index');

// รายละเอียดหลักสูตร
Route::get('/programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');

// รายละเอียด Session
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');

// ตรวจสอบ Certificate
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::get('/certificate/verify/{hash}', [CertificateController::class, 'verify'])->name('certificates.verify.hash');

// Certificate generate (Admin)
Route::get('/certificate/generate/{user}/{session}', [CertificateController::class, 'generate']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');

    // Registration
    Route::post('/sessions/{session}/register', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [\App\Http\Controllers\RegistrationController::class, 'destroy'])->name('registrations.cancel');
    Route::get('/programs/{id}/register', [ProgramsController::class, 'register'])->name('programs.register');

    // Feedback
    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');

    // Certificates download
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/my-courses/upcoming', [ProfileController::class, 'upcomingCourses'])->name('profile.courses.upcoming');
    Route::get('/my-courses/history', [ProfileController::class, 'courseHistory'])->name('profile.courses.history');
    Route::get('/my-certificates', [CertificateController::class, 'collection'])->name('certificates.collection');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('programs', AdminProgramController::class); // <-- ใช้ Controller ที่เปลี่ยนชื่อ
        Route::resource('trainers', TrainerController::class);

        Route::get('/attendance/overview', [AttendanceController::class, 'overview'])
        ->name('attendance.overview');

        Route::resource('certificates', CertificateAdminController::class);

        Route::resource('categories', CategoryController::class);
        // Route::resource('levels', LevelController::class);


        Route::resource('programs.sessions', SessionController::class);
        Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
                Route::get('/sessions/{session}/registrations', [RegistrationController::class, 'index'])->name('registrations.index');

    // Complete Session
    Route::post('/sessions/{session}/complete', [SessionCompletionController::class, 'complete'])->name('sessions.complete');

    // Program extra actions
    Route::get('/programs/create-flow', [AdminProgramController::class, 'createCourseFlow'])->name('programs.create-flow');
    Route::post('/programs/quick-store', [AdminProgramController::class, 'quickStore'])->name('programs.quick-store');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/{sessionId}', [AdminFeedbackController::class, 'report'])->name('feedback.report');
    });

    // Export Feedback CSV
    Route::get('/feedbacks/export', [AdminFeedbackController::class, 'export'])->name('feedbacks.export');
});

/*
|--------------------------------------------------------------------------
| OTP & Password Reset Routes
|--------------------------------------------------------------------------
*/
Route::get('/password/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify.code');
Route::get('/password/reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/update-with-code', [PasswordResetController::class, 'updatePassword'])->name('password.update.with.code');

// Include Breeze Auth
require __DIR__.'/auth.php';
