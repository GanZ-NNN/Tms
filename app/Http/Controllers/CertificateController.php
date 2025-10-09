<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;



class CertificateController extends Controller
{
    // ✅ ดาวน์โหลดใบรับรอง (เฉพาะเมื่อผ่านเงื่อนไข)
    public function download(Certificate $certificate)
    {
        $user = auth()->user();

        if ($certificate->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $attendanceRate = $certificate->session->attendanceRateFor($user);
        $hasFeedback = $certificate->session->hasFeedbackFrom($user);

        if ($attendanceRate < 80 || !$hasFeedback) {
            return redirect()->back()->with(
                'error',
                'คุณต้องเข้าร่วมอย่างน้อย 80% และทำแบบประเมินก่อนดาวน์โหลดใบรับรอง'
            );
        }

        if (!Storage::exists($certificate->pdf_path)) {
            abort(404, 'Certificate file not found.');
        }

        return Storage::download($certificate->pdf_path, "{$certificate->cert_no}.pdf");
    }

    // ✅ ตรวจสอบความถูกต้องของใบรับรอง
    public function verify($hash)
    {
        $certificate = Certificate::where('verification_hash', $hash)->first();

        if (!$certificate) {
            return view('certificates.verify', ['valid' => false]);
        }

        return view('certificates.verify', [
            'valid' => true,
            'certificate' => $certificate
        ]);
    }

       // CertificateController@collection

public function collection(Request $request): View
{
    $user = $request->user();

    // 1. ดึง Certificate ที่ได้รับแล้ว (เหมือนเดิม)
    $issuedCertificates = $user->certificates()->with('session.program')->latest('issued_at')->get();

    // 2. ดึงประวัติการอบรมทั้งหมดที่จบแล้ว
    $completedSessionsHistory = $user->registrations()
        ->with([
            'session.program',
            'session.attendances' => fn($q) => $q->where('user_id', $user->id),
            'session.feedback' => fn($q) => $q->where('user_id', $user->id) // <-- เพิ่ม Eager Load
        ])
        ->whereHas('session', fn($q) => $q->where('status', 'completed'))
        ->get();

    // 3. กรองหา "Certificate ที่ไม่ผ่านเกณฑ์" (ส่วนที่แก้ไข)
    $unissuedCertificates = $completedSessionsHistory->filter(function ($registration) use ($issuedCertificates, $user) {
        
        // ถ้ามี Certificate ออกให้แล้ว -> ไม่ต้องแสดงในส่วนนี้
        if ($issuedCertificates->contains('session_id', $registration->session_id)) {
            return false;
        }

        // --- นี่คือ Logic การตัดสินใหม่ ---
        $reasons = [];

        // เงื่อนไข 1: การเข้าเรียน
        $attended = $registration->session->attendances->isNotEmpty();
        if (!$attended) {
            $reasons[] = 'ไม่ผ่านเกณฑ์การเข้าเรียน';
        }

        // เงื่อนไข 2: การส่ง Feedback
        $submittedFeedback = $registration->session->feedback->isNotEmpty();
        if (!$submittedFeedback) {
            $reasons[] = 'ยังไม่ได้ส่งแบบประเมิน';
        }
        
        // ถ้ามีเหตุผลที่ไม่ผ่านอย่างน้อย 1 ข้อ -> ถือว่าไม่ผ่านเกณฑ์
        if (!empty($reasons)) {
            // เก็บเหตุผลไว้ใน property ใหม่
            $registration->reasonsForFailure = implode(' และ ', $reasons);
            return true;
        }
        
        // ถ้าผ่านทุกเงื่อนไข แต่ยังไม่มี Certificate (อาจจะกำลังรอ Admin สร้าง)
        return false;

    })->map(function ($registration) {
        // สร้าง Object ปลอมๆ เพื่อให้ใช้ง่ายใน View
        return (object)[
            'session' => $registration->session,
            'reason' => $registration->reasonsForFailure // ใช้เหตุผลที่เรารวบรวมไว้
        ];
    });

    return view('certificates.collection', compact('issuedCertificates', 'unissuedCertificates'));
}

}
