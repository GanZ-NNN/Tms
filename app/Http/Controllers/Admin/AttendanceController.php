<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession; // หรือ Session
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show the attendance form for a specific session.
     */
    public function show(TrainingSession $session)
    {
        // โหลดข้อมูลที่จำเป็น: program, registrations พร้อม user, และ attendances ที่มีอยู่แล้ว
        $session->load(['program', 'registrations.user', 'attendances']);

        // สร้าง Array ของ user_id ที่เคยเช็คชื่อไว้แล้ว เพื่อให้ง่ายต่อการตรวจสอบใน Blade
        $attendedUserIds = $session->attendances->pluck('user_id')->all();

        return view('admin.attendance.show', compact('session', 'attendedUserIds'));
    }

    /**
     * Store the attendance data.
     */
    public function store(Request $request, TrainingSession $session)
    {
        $request->validate([
            'attendees' => 'nullable|array',
            'attendees.*' => 'integer|exists:users,id', // ตรวจสอบว่า ID ที่ส่งมามีจริงในตาราง users
        ]);

        // 1. ลบข้อมูลการเช็คชื่อเก่าของ Session นี้ทิ้งทั้งหมด
        $session->attendances()->delete();

        // 2. ถ้ามีการส่งรายชื่อคนที่มาเรียนมา (คนที่ถูกติ๊ก checkbox)
        if ($request->has('attendees')) {
            // 3. เตรียมข้อมูล Array สำหรับ Insert ทีเดียว (เร็วกว่าการ Create ใน Loop)
            $attendeesData = collect($request->attendees)->map(function ($userId) use ($session) {
                return [
                    'session_id' => $session->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            // 4. Insert ข้อมูลใหม่ทั้งหมดลงตาราง attendances
            Attendance::insert($attendeesData->toArray());
        }

        return redirect()->route('admin.dashboard') // หรือจะกลับไปหน้า Session Management ก็ได้
                         ->with('success', 'Attendance for "' . ($session->title ?? $session->program->title) . '" has been saved.');
    }

        public function overview()
    {
        // ดึงข้อมูล Session ทั้งหมดที่ยังไม่จบ หรือจบไปไม่นาน
        // เพื่อให้ Admin สามารถเลือกได้ว่าจะเช็คชื่อรอบไหน
        $sessions = TrainingSession::with('program')
                        ->where('status', '!=', 'cancelled')
                        ->where('end_at', '>', now()->subDays(7)) // เอาเฉพาะที่เพิ่งจบไปใน 7 วัน หรือยังไม่จบ
                        ->latest('start_at')
                        ->paginate(20);

        return view('admin.attendance.overview', compact('sessions'));
    }
    
}