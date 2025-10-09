<?php
use App\Models\Certificate;
use Illuminate\Support\Facades\Route;

// --- Controllers ---
// Admin
use App\Http\Controllers\Admin\SessionDashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SessionCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CertificateAdminController;

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\RegistrationController;

// Frontend
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\PublicSessionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificateController;


// Auth (Breeze / OTP Reset Password)
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // สำหรับ logout

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', [HomeController::class, 'index'])->name('home');

// หน้ารวมหลักสูตรทั้งหมด
Route::get('/programs', [ProgramsController::class, 'index'])->name('programs.index');

// หน้ารายละเอียดหลักสูตร
Route::get('/programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');

// หน้ารายละเอียด Session
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('sessions.show');

// หน้าตรวจสอบ Certificate
Route::get('/certificate/verify', [CertificateController::class, 'showVerificationForm'])->name('certificates.verify.form');
Route::post('/certificate/verify', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::get('/certificate/verify/{hash}', [CertificateController::class, 'verify'])
    ->name('certificates.verify.hash');


// Certificate generate (Admin)
Route::get('/certificate/generate/{user}/{session}', [CertificateController::class, 'generate']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard redirect


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-courses', [ProfileController::class, 'myCourses'])->name('profile.courses');

    // Registration
    Route::post('/sessions/{session}/register', [RegistrationController::class, 'store'])->name('sessions.register');
    Route::delete('/registrations/{registration}/cancel', [RegistrationController::class, 'destroy'])->name('registrations.cancel');
    Route::get('/programs/{id}/register', [ProgramsController::class, 'register'])->name('programs.register');

    // Feedback
    Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Certificates download
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Logout (POST)
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
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SessionDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('programs', AdminProgramController::class); // <-- ใช้ Controller ที่เปลี่ยนชื่อ
        Route::resource('trainers', TrainerController::class);

        Route::get('/attendance/overview', [AttendanceController::class, 'overview'])
        ->name('attendance.overview');
        Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

        // Route::resource('certificates', App\Http\Controllers\Admin\CertificateAdminController::class);
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
        Route::get('/feedback', [App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/{sessionId}', [App\Http\Controllers\Admin\FeedbackController::class, 'report'])->name('feedback.report');
    });

    // ✅ เพิ่ม route สำหรับ export CSV
    Route::get('/feedbacks/export', [App\Http\Controllers\Admin\FeedbackController::class, 'export'])
        ->name('feedbacks.export');
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

/*
|--------------------------------------------------------------------------
| FEEDBACK REPORT (FRONTEND)
|--------------------------------------------------------------------------
*/
Route::get('/sessions/{session}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/sessions/{session}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/thankyou', [FeedbackController::class, 'thankyou'])->name('feedback.thankyou');


Route::get('/admin/users/search', [CertificateAdminController::class, 'searchUsers'])->name('admin.users.search');
Route::get('/admin/sessions/search', [CertificateAdminController::class, 'searchSessions'])->name('admin.sessions.search');

Route::get('/admin/certificates/{certificate}/pdf', function(Certificate $certificate) {
    if (!$certificate->pdf_path || !Storage::exists($certificate->pdf_path)) {
        abort(404); // ถ้าไฟล์ไม่มี
    }
    return Storage::download($certificate->pdf_path, $certificate->cert_no . '.pdf');
})->name('admin.certificates.download');

/*
|--------------------------------------------------------------------------
| INCLUDE BREEZE AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
