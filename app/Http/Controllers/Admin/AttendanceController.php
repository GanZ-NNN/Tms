<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession; // หรือ Session
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

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
            $period = CarbonPeriod::create($session->start_at, $session->end_at);
            foreach ($period as $date) {
                $dateString = $date->format('Y-m-d');
                
                \App\Models\DailyAttendance::updateOrCreate(
                    [
                        'registration_id' => $registration->id,
                        'attendance_date' => $dateString,
                    ],
                    [
                        'is_present_am' => isset($validated['attendance'][$registration->id][$dateString]['am']),
                        'is_present_pm' => isset($validated['attendance'][$registration->id][$dateString]['pm']),
                    ]
                );
            }
        }
        return back()->with('success', 'Attendance has been saved successfully.');
    }

    public function overview()
    {
        $programs = \App\Models\Program::with(['sessions' => function ($query) {
                $query->where('status', '!=', 'cancelled')->orderBy('start_at', 'desc');
            }, 'sessions.trainer', 'sessions.level'])
            ->whereHas('sessions') // เอาเฉพาะ Program ที่มี Session
            ->latest()
            ->get();

        return view('admin.attendance.overview', compact('programs'));
    }
    
}