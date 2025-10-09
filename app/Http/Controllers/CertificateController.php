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

    // 1. ดึง Certificate ทั้งหมดที่ผู้ใช้ได้รับแล้ว
    $issuedCertificates = $user->certificates()->with('session.program')->latest('issued_at')->get();
    $issuedSessionIds = $issuedCertificates->pluck('session_id'); // <-- เก็บ ID ของ Session ที่มี Cert แล้ว

    // 2. ดึงประวัติการอบรมทั้งหมดที่จบแล้ว
    $completedSessionsHistory = $user->registrations()
        ->with(['session.program', 'session.attendances', 'session.feedback' => fn($q) => $q->where('user_id', $user->id)])
        ->whereHas('session', fn($q) => $q->where('status', 'completed'))
        // *** สำคัญ: ไม่ต้องดึง Session ที่มี Cert แล้วมาซ้ำ ***
        ->whereNotIn('session_id', $issuedSessionIds) 
        ->get();
    
    // 3. กรองหา "Certificate ที่ไม่ผ่านเกณฑ์" จากรายการที่เหลือ
    $unissuedCertificates = $completedSessionsHistory->map(function ($registration) {
        $reasons = [];
        
        // ... Logic การหาเหตุผล (เหมือนเดิม) ...
        $attended = $registration->session->attendances->isNotEmpty();
        if (!$attended) $reasons[] = 'ไม่ผ่านเกณฑ์การเข้าเรียน';

        $submittedFeedback = $registration->session->feedback->isNotEmpty();
        if (!$submittedFeedback) $reasons[] = 'ยังไม่ได้ส่งแบบประเมิน';

        // ถ้ามีเหตุผล ก็สร้าง object
        if (!empty($reasons)) {
            return (object)[
                'session' => $registration->session,
                'reason' => implode(' และ ', $reasons)
            ];
        }
        return null; // ถ้าผ่านเกณฑ์ แต่ยังไม่มี Cert (รอ Admin สร้าง) ก็ไม่ต้องแสดง
    })->filter(); // filter() จะลบค่า null ออกไป

    return view('certificates.collection', compact('issuedCertificates', 'unissuedCertificates'));
}

}
