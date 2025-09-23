<?php

namespace App\Http\Controllers;

use App\Models\Session; // <-- เพิ่ม use statement นี้
use Illuminate\Http\Request;

class PublicSessionController extends Controller
{
    /**
     * Display a listing of upcoming sessions for public users.
     * (นี่คือเมธอดสำหรับหน้าแรก)
     */
    public function index()
    {
        // ดึงข้อมูล Session ทั้งหมดที่ยังไม่จบ (สถานะ scheduled) และเรียงตามวันที่เริ่ม
        $sessions = Session::with(['program', 'trainer'])
                            ->where('status', 'scheduled')
                            ->where('start_at', '>=', now()) // เอาเฉพาะรอบอบรมในอนาคต
                            ->orderBy('start_at', 'asc');
                            // ->paginate(9);

        // ส่งข้อมูลไปที่ View ของหน้าแรก
        return view('welcome', compact('sessions'));
        // หรือถ้าคุณสร้าง View แยก ให้เปลี่ยนเป็น return view('sessions.index', ...);
    }

    /**
     * Display the specified session details.
     * (เมธอดสำหรับแสดงรายละเอียดของแต่ละ Session)
     */
    public function show(Session $session)
    {
        // โหลดข้อมูลที่เกี่ยวข้องมาด้วย
        $session->load(['program.category', 'trainer', 'registrations']);

        // ส่งข้อมูลไปที่ View แสดงรายละเอียด
        return view('sessions.show', compact('session'));
    }
}
