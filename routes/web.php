<?php

use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
// Admin Controllers
use App\Http\Controllers\Admin\SessionDashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SessionCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LevelController;

// Frontend User Controllers
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;


// === Public Routes (ทุกคนเข้าได้ ไม่ต้อง Login) ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');


// === Authenticated User Routes (ต้อง Login ก่อน) ===
Route::middleware('auth')->group(function () {

    // -- User Profile & Dashboard --
    Route::get('/dashboard', function () {
        // Redirect ไปหน้าโปรไฟล์ หรือหน้ารายการคอร์ส
        return redirect()->route('profile.edit');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');

    // -- Registration & Feedback --
    Route::post('/sessions/{session}/register', [RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [RegistrationController::class, 'destroy'])->name('registrations.cancel');

    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // -- Certificate Download --
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
});


// === Admin Only Routes (ต้อง Login และเป็น Admin) ===
Route::middleware(['auth', 'verified', 'is.admin' ]) // <-- คุณต้องสร้าง Middleware 'is.admin' เอง
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

    // -- Main Dashboard --
    Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');


    Route::resource('users', UserController::class);

    // -- CRUD Resources --
    Route::resource('programs', ProgramController::class);
    Route::resource('trainers', TrainerController::class);
    Route::resource('categories', CategoryController::class);

    // -- Nested Resource for Sessions within a Program (สำหรับปุ่ม Manage เดิม) --
    Route::resource('programs.sessions', SessionController::class);

    // -- Attendance Routes --
    Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance', [AttendanceController::class, 'overview'])->name('attendance.overview');

    // -- Other Session Actions --
    Route::post('/sessions/{session}/complete', [SessionCompletionController::class, 'complete'])->name('sessions.complete');

    // -- Special "Create Course + Session" Flow --
    Route::get('/programs/create-flow', [ProgramController::class, 'createCourseFlow'])->name('programs.create-flow');
    Route::post('/programs/quick-store', [ProgramController::class, 'quickStore'])->name('programs.quick-store');

    Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

    Route::resource('levels', LevelController::class);
});

Route::resource('programs', ProgramController::class);
Route::get('/programs/search', [ProgramController::class, 'search'])->name('programs.search');
Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

Route::resource('programs', HomeController::class);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/programs/{program}', [HomeController::class, 'show'])->name('programs.show');


// --- Include Breeze's Auth Routes ---
require __DIR__.'/auth.php';
