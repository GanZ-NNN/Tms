<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TrainingSession;
use App\Models\Registration;
use App\Models\Feedback;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class SessionDashboardController extends Controller
{
    public function index()
    {
        // --- Stat Cards Data ---
        $stats = [
            'total_trainees' => User::where('role', 'trainee')->count(),
            'upcoming_sessions' => TrainingSession::where('status', 'scheduled')
                                        ->where('start_at', '>', now())
                                        ->count(),
            'pending_payments' => 0,
            'completed_this_month' => TrainingSession::where('status', 'completed')
                                            ->whereMonth('end_at', now()->month)
                                            ->whereYear('end_at', now()->year)
                                            ->count(),
        ];

        // --- Users by Occupation Chart Data ---
$userByOccupation = User::select('occupation', DB::raw('COUNT(*) as total'))
    ->whereIn('occupation', [
        'นักศึกษาในคณะ',
        'นักศึกษามข',
        'อาจารย์ในคณะ',
        'อาจารย์มข',
        'บุคคลภายนอก',
    ])
    ->groupBy('occupation')
    ->pluck('total', 'occupation');

$occupationChartData = [
    'labels' => $userByOccupation->keys(),
    'data' => $userByOccupation->values(),
];


        // --- Attendance Chart Data ---
        $monthlyAttendance = Attendance::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(DISTINCT user_id) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M Y');
            $data[] = $monthlyAttendance->first(function ($item) use ($month) {
                return $item->year == $month->year && $item->month == $month->month;
            })->count ?? 0;
        }

        $attendanceChartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        // --- Upcoming Sessions ---
        $upcomingSessions = TrainingSession::with(['program', 'registrations'])
                                ->where('start_at', '>', now())
                                ->orderBy('start_at', 'asc')
                                ->limit(5)
                                ->get();

        // --- Sessions Awaiting Completion ---
        $sessionsToComplete = TrainingSession::with('program')
                                ->where('end_at', '<', now())
                                ->where('status', '!=', 'completed')
                                ->orderBy('end_at', 'desc')
                                ->limit(5)
                                ->get();

        // --- Feedback Chart Data (แก้ไขให้ตรงกับ DB) ---
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

        // --- Recent Activities ---
        $recentActivities = Registration::with(['user', 'session.program'])
                                ->latest()
                                ->limit(5)
                                ->get();

        // --- Sessions at Risk ---
        $lowEnrollmentSessions = TrainingSession::with('registrations')
            ->where('start_at', '>', now())
            ->where('start_at', '<=', now()->addDays(7))
            ->get()
            ->filter(fn($session) => $session->capacity && ($session->registrations->count() / $session->capacity) < 0.25);

        $nearingCapacitySessions = TrainingSession::with('registrations')
            ->where('start_at', '>', now())
            ->get()
            ->filter(fn($session) => $session->capacity && ($session->registrations->count() / $session->capacity) > 0.85);

        // --- ส่งตัวแปรไป View ---
        return view('admin.dashboard', compact(
            'stats',
            'attendanceChartData',
            'upcomingSessions',
            'sessionsToComplete',
            'feedbackChartData',
            'recentActivities',
            'lowEnrollmentSessions',
            'nearingCapacitySessions'
            ,'occupationChartData'
        ));
    }
}
