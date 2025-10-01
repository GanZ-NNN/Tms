<?php

use Illuminate\Support\Facades\Route;

// --- Controllers ---
// Admin
use App\Http\Controllers\Admin\SessionDashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SessionCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LevelController;

// Frontend
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramsController;

// Auth (OTP Reset Password)
use App\Http\Controllers\Auth\PasswordResetController;

// === Public Routes (ทุกคนเข้าได้ ไม่ต้อง Login) ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');

// *** ส่วนที่แก้ไข ***
// เปลี่ยนชื่อ Route 'programs.index' เป็น 'courses.index' เพื่อให้ตรงกับ Navigation
Route::get('/programs', [ProgramsController::class, 'index'])->name('courses.index');
// *** สิ้นสุดส่วนที่แก้ไข ***

// แสดงรายละเอียดโปรแกรม
Route::get('/programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');

// ✅ ลงทะเบียนต้อง login ก่อน
Route::middleware('auth')->group(function () {
    Route::get('/programs/{id}/register', [ProgramsController::class, 'register'])->name('programs.register');
});

// === Authenticated User Routes (ต้อง Login ก่อน) ===
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('profile.edit'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');
    Route::post('/sessions/{session}/register', [RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [RegistrationController::class, 'destroy'])->name('registrations.cancel');
    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
});

// --- Admin Routes (ต้อง Login + Verified + Admin) ---
Route::middleware(['auth', 'is.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('programs', ProgramController::class);
        Route::resource('trainers', TrainerController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('programs.sessions', SessionController::class);
        Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance', [AttendanceController::class, 'overview'])->name('attendance.overview');
        Route::post('/sessions/{session}/complete', [SessionCompletionController::class, 'complete'])->name('sessions.complete');
        Route::get('/programs/create-flow', [ProgramController::class, 'createCourseFlow'])->name('programs.create-flow');
        Route::post('/programs/quick-store', [ProgramController::class, 'quickStore'])->name('programs.quick-store');
        Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
        Route::resource('levels', LevelController::class);
    });

// --- Frontend Program Routes (อีกเวอร์ชันที่โชว์ผ่าน HomeController) ---
// ผมได้คอมเมนต์ส่วนนี้ออก เพราะมันซ้ำซ้อนกับ Route ด้านบน และอาจทำให้เกิดความสับสน
// Route::get('/programs', [HomeController::class, 'programsIndex'])->name('programs.index');
// Route::get('/programs/{program}', [HomeController::class, 'show'])->name('programs.show');

// OTP verify
Route::get('/password/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify.code');

// Reset Password
Route::get('/password/reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/update-with-code', [PasswordResetController::class, 'updatePassword'])->name('password.update.with.code');

// --- Include Breeze's Auth Routes ---
require __DIR__.'/auth.php';
