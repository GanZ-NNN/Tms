<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession; // หรือ Session
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use App\Models\Certificate;


class AttendanceController extends Controller
{
    /**
     * Show the attendance form for a specific session.
     */
    public function show(TrainingSession $session)
    {
        $session->load('program', 'registrations.user', 'registrations.dailyAttendances');

        // สร้างช่วงวันที่สำหรับการอบรม
        $period = CarbonPeriod::create($session->start_at, $session->end_at);

        // จัดข้อมูล dailyAttendances ให้อยู่ในรูปแบบที่ใช้ง่ายใน View
        $attendancesLookup = [];
        foreach ($session->registrations as $reg) {
            foreach ($reg->dailyAttendances as $att) {
                $attendancesLookup[$reg->id][$att->attendance_date] = [
                    'am' => $att->is_present_am,
                    'pm' => $att->is_present_pm,
                ];
            }
        }

        return view('admin.attendance.show', compact('session', 'period', 'attendancesLookup'));
    }

    /**
     * Store the attendance data.
     */
    public function store(Request $request, TrainingSession $session)
{
    $validated = $request->validate(['attendance' => 'nullable|array']);

    foreach ($session->registrations as $registration) {
        $period = \Carbon\CarbonPeriod::create($session->start_at, $session->end_at);

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');

            \App\Models\DailyAttendance::updateOrCreate(
                [
                    'registration_id' => $registration->id,
                    'attendance_date' => $dateString,
                ],
                [
                    'is_present_am' => $validated['attendance'][$registration->id][$dateString]['am'] ?? false,
                    'is_present_pm' => $validated['attendance'][$registration->id][$dateString]['pm'] ?? false,
                ]
            );
        }

        // ✅ ตรวจสอบเงื่อนไข Certificate
        $user = $registration->user;
        $attendanceRate = $session->attendanceRateFor($user);
        $hasFeedback = $session->hasFeedbackFrom($user);

        if ($attendanceRate >= 80 && $hasFeedback) {
            Certificate::firstOrCreate([
                'user_id' => $user->id,
                'session_id' => $session->id
            ]);
        }
    }

    return redirect()->route('admin.attendance.overview')
                     ->with('success', 'Attendance for "' . ($session->title ?? $session->program->title) . '" has been saved.');
}

    public function overview()
{
    $programs = \App\Models\Program::with([
        'sessions' => function ($query) {
            $query->where('status', '!=', 'cancelled')->orderBy('start_at', 'desc');
        },
        'sessions.trainer',
        'sessions.registrations.dailyAttendances',
    ])->whereHas('sessions')
      ->latest()
      ->get();

    // เพิ่มค่าเฉลี่ย attendance ให้แต่ละ session
    foreach ($programs as $program) {
        foreach ($program->sessions as $session) {
            $period = \Carbon\CarbonPeriod::create($session->start_at, $session->end_at);
            $daysCount = count($period);
            $totalSlots = $session->registrations->count() * $daysCount * 2; // AM + PM

            $attended = 0;
            foreach ($session->registrations as $reg) {
                $attended += $reg->dailyAttendances->sum(fn($a) => ($a->is_present_am ? 1 : 0) + ($a->is_present_pm ? 1 : 0));
            }

            $session->avg_attendance = $totalSlots > 0 ? round(($attended / $totalSlots) * 100, 2) : 0;
        }
    }

    return view('admin.attendance.overview', compact('programs'));
}



    public function attendanceRate($registration, $session)
{
    $period = \Carbon\CarbonPeriod::create($session->start_at, $session->end_at);
    $totalSlots = count($period) * 2; // AM + PM ต่อวัน

    $attended = $registration->dailyAttendances->sum(function($a) {
        return ($a->is_present_am ? 1 : 0) + ($a->is_present_pm ? 1 : 0);
    });

    return $totalSlots > 0 ? round(($attended / $totalSlots) * 100, 2) : 0;
}

}
