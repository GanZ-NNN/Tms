<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession; // หรือ Session
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Store a new registration in storage.
     */
    public function store(Request $request, TrainingSession $session)
    {
        // 1. ตรวจสอบว่าผู้ใช้ Login แล้วหรือยัง
        if (!Auth::check()) {
            // ถ้ายังไม่ Login, ให้จำ URL นี้ไว้ แล้วส่งไปหน้า Login
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // 2. ตรวจสอบว่าเคยลงทะเบียนไปแล้วหรือยัง
        $alreadyRegistered = Registration::where('user_id', $user->id)
                                         ->where('session_id', $session->id)
                                         ->exists();
        if ($alreadyRegistered) {
            return back()->with('error', 'You are already registered for this session.');
        }

        // 3. ตรวจสอบว่าที่นั่งเต็มหรือยัง (ถ้ามี capacity)
        if ($session->capacity) {
            $registrationCount = Registration::where('session_id', $session->id)->count();
            if ($registrationCount >= $session->capacity) {
                return back()->with('error', 'Sorry, this session is full.');
            }
        }
        
        // 4. ถ้าทุกอย่างผ่าน, ทำการสร้างการลงทะเบียน
        Registration::create([
            'user_id' => $user->id,
            'session_id' => $session->id,
            // 'status' => 'registered', // ถ้าตาราง registrations มีคอลัมน์ status
        ]);

        // 5. Redirect กลับไปหน้าเดิม พร้อมข้อความแจ้งเตือน
        return back()->with('success', 'You have successfully registered for the session!');
    }

    public function destroy(Registration $registration)
    {
        // 1. ตรวจสอบสิทธิ์ (Authorization)
        //    ให้แน่ใจว่าคนที่กำลังจะลบ คือเจ้าของการลงทะเบียนนั้นจริงๆ
        if (Auth::id() !== $registration->user_id) {
            abort(403, 'Unauthorized Action');
        }

        // (Optional) ตรวจสอบเงื่อนไขเพิ่มเติม
        // เช่น ไม่สามารถยกเลิกได้หากการอบรมเริ่มไปแล้ว
        // if ($registration->session->start_at < now()) {
        //     return back()->with('error', 'You cannot cancel a registration for a session that has already started.');
        // }

        // 2. ทำการลบข้อมูลการลงทะเบียน
        $registration->delete();

        // 3. Redirect กลับไปหน้าเดิม พร้อมข้อความแจ้งเตือน
        return back()->with('success', 'Your registration has been successfully cancelled.');
    }
}