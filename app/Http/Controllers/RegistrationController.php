<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;
use App\Mail\RegistrationCanceledMail;

class RegistrationController extends Controller
{
    /**
     * บันทึกข้อมูลการลงทะเบียนใหม่
     */
    public function store(Request $request, TrainingSession $session)
    {
        // 1. ตรวจสอบการล็อกอิน
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // 2. ตรวจสอบว่าเคยลงทะเบียนหรือยัง
        $alreadyRegistered = Registration::where('user_id', $user->id)
                                         ->where('session_id', $session->id)
                                         ->exists();
        if ($alreadyRegistered) {
            return back()->with('error', 'คุณได้ลงทะเบียนในรอบนี้แล้ว');
        }

        // 3. ตรวจสอบจำนวนที่นั่ง
        if ($session->capacity) {
            $registrationCount = Registration::where('session_id', $session->id)->count();
            if ($registrationCount >= $session->capacity) {
                return back()->with('error', 'ขออภัย รอบอบรมนี้เต็มแล้ว');
            }
        }

        // 4. สร้างการลงทะเบียน
        $registration = Registration::create([
            'user_id' => $user->id,
            'session_id' => $session->id,
        ]);

        // 5. ส่งอีเมลแจ้งผู้ลงทะเบียน
        Mail::to($user->email)->send(new RegistrationSuccessMail($user, $session));

        // 6. กลับไปพร้อม SweetAlert
        return redirect()->route('home')->with('registration_success', true);
    }

    /**
     * ยกเลิกการลงทะเบียน
     */
    public function destroy(Registration $registration)
    {
        $user = Auth::user(); // ✅ ต้องประกาศก่อนใช้

        // ตรวจสอบสิทธิ์
        if ($user->id !== $registration->user_id) {
            abort(403, 'Unauthorized Action');
        }

        // เก็บ session ก่อนลบ (เพราะลบแล้วจะอ้างอิงไม่ได้)
        $session = $registration->session;

        // ลบการลงทะเบียน
        $registration->delete();

        // ส่งอีเมลยืนยันการยกเลิก
        Mail::to($user->email)->send(new RegistrationCanceledMail($user, $session));

        return back()->with('cancel_success', true);
    }
}
