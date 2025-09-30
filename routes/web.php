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

// --- Public Routes (ไม่ต้อง Login) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');

// --- Authenticated Routes (ต้อง Login + Verified) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect
    Route::get('/dashboard', fn() => redirect()->route('profile.edit'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');

    // Session Registration
    Route::post('/sessions/{session}/register', [RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [RegistrationController::class, 'destroy'])->name('registrations.cancel');

    // Feedback
    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Certificates
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
});

// --- Admin Routes (ต้อง Login + Verified + Admin) ---
Route::middleware(['auth', 'verified', 'is.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::resource('users', UserController::class);

    // -- CRUD Resources --
    Route::resource('programs', ProgramController::class);
    Route::resource('trainers', TrainerController::class);
    Route::resource('categories', CategoryController::class);

        // Nested Sessions inside Programs
        Route::resource('programs.sessions', SessionController::class);

        // Attendance
        Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance', [AttendanceController::class, 'overview'])->name('attendance.overview');

        // Complete Session
        Route::post('/sessions/{session}/complete', [SessionCompletionController::class, 'complete'])->name('sessions.complete');

        // Special Program Flow
        Route::get('/programs/create-flow', [ProgramController::class, 'createCourseFlow'])->name('programs.create-flow');
        Route::post('/programs/quick-store', [ProgramController::class, 'quickStore'])->name('programs.quick-store');

        // Show Program
        Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
    });

// --- Frontend Program Routes ---
Route::get('/programs', [HomeController::class, 'programsIndex'])->name('programs.index');
Route::get('/programs/{program}', [HomeController::class, 'show'])->name('programs.show');

// --- Auth Routes (Breeze / Fortify) ---
require __DIR__.'/auth.php';
