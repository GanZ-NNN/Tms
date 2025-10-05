<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TrainingSession; // หรือ Session
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Feedback;

class SessionDashboardController extends Controller
{
    /**
     * Display the main admin dashboard with stats and actionable lists.
     */
    public function index()
    {
        // --- Stat Cards Data ---
        $stats = [
            'total_trainees' => User::where('role', 'trainee')->count(),
            'upcoming_sessions' => TrainingSession::where('status', 'scheduled') // <-- เพิ่มเงื่อนไขนี้
                                       ->where('start_at', '>', now())
                                       ->count(),
            'pending_payments' => 0, // ตั้งเป็น 0 ไปก่อน ถ้ายังไม่มีระบบจ่ายเงิน
            'completed_this_month' => TrainingSession::where('status', 'completed')
                                            ->whereMonth('end_at', now()->month)
                                            ->whereYear('end_at', now()->year)
                                            ->count(),
        ];

        // --- Left Column Data ---

        // 1. กราฟเส้น: Monthly Registration Trend
        $registrationTrend = Registration::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartData = [
            'labels' => $registrationTrend->map(fn($item) => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year))),
            'data' => $registrationTrend->pluck('count'),
        ];

        // 2. ตาราง: Upcoming Sessions (List)
        $upcomingSessions = TrainingSession::with(['program', 'registrations'])
                                ->where('start_at', '>', now())
                                ->orderBy('start_at', 'asc')
                                ->limit(5)
                                ->get();

        // 3. ตาราง: Sessions Awaiting Action (List)
        $sessionsToComplete = TrainingSession::with('program')
                                ->where('end_at', '<', now())
                                ->where('status', '!=', 'completed')
                                ->orderBy('end_at', 'desc')
                                ->limit(5)
                                ->get();

        // --- Right Column Data (ส่วนที่เพิ่มเข้ามา) ---

        // 1. กราฟวงกลม: Overall Feedback Rating
        // 'rating' column doesn't exist; use 'overall' which stores the overall rating
        $feedbackRating = Feedback::select(
                'overall',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('overall')
            ->orderBy('overall', 'desc')
            ->pluck('count', 'overall');

        $feedbackChartData = [
            'labels' => $feedbackRating->keys()->map(fn($rating) => "$rating Stars"),
            'data' => $feedbackRating->values(),
        ];

        // 2. รายการ: Activity Feed (ดึงการลงทะเบียนล่าสุด)
        $recentActivities = Registration::with(['user', 'session.program'])
                            ->latest()
                            ->limit(5)
                            ->get();

        // 3. รายการ: Sessions at Risk
        $lowEnrollmentSessions = TrainingSession::with('registrations')
            ->where('start_at', '>', now())
            ->where('start_at', '<=', now()->addDays(7))
            ->get()
            ->filter(function ($session) {
                if (empty($session->capacity) || $session->capacity == 0) return false;
                return ($session->registrations->count() / $session->capacity) < 0.25;
            });

        $nearingCapacitySessions = TrainingSession::with('registrations')
            ->where('start_at', '>', now())
            ->get()
            ->filter(function ($session) {
                if (empty($session->capacity) || $session->capacity == 0) return false;
                return ($session->registrations->count() / $session->capacity) > 0.85;
            });

        // --- ส่งตัวแปรทั้งหมดไปที่ View ---
        return view('admin.dashboard', compact(
            'stats',
            'chartData',
            'upcomingSessions',
            'sessionsToComplete',
            'feedbackChartData',
            'recentActivities',
            'lowEnrollmentSessions',
            'nearingCapacitySessions'
        ));
    }
}
