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

        public function collection(Request $request): View
    {
        $user = $request->user();

        // 1. ดึง Certificate ทั้งหมดที่ผู้ใช้ได้รับแล้วจริงๆ
        $issuedCertificates = $user->certificates()
                                  ->with('session.program')
                                  ->latest('issued_at')
                                  ->get();

        // 2. ดึง "ประวัติการอบรมทั้งหมด" ที่จบแล้ว (status = completed)
        $completedSessionsHistory = $user->registrations()
            ->with(['session.program', 'session.attendances' => fn($q) => $q->where('user_id', $user->id)])
            ->whereHas('session', fn($q) => $q->where('status', 'completed'))
            ->get();

        // 3. กรองหา "Certificate ที่ไม่ผ่านเกณฑ์"
        $unissuedCertificates = $completedSessionsHistory->filter(function ($registration) use ($issuedCertificates) {
            
            // เช็คก่อนว่ามี Certificate ออกให้สำหรับ Session นี้แล้วหรือยัง
            $alreadyIssued = $issuedCertificates->contains('session_id', $registration->session_id);
            if ($alreadyIssued) {
                return false; // ถ้ามีแล้ว ไม่ต้องแสดงในส่วนที่ไม่ผ่าน
            }

            // --- นี่คือ Logic การตัดสิน ---
            // เงื่อนไข: "มาเรียน" (มี record ใน attendances)
            $attended = $registration->session->attendances->isNotEmpty();
            
            // ถ้าไม่มาเรียน -> ถือว่าไม่ผ่านเกณฑ์
            return !$attended;

        })->map(function ($registration) {
            // สร้าง Object ปลอมๆ เพื่อให้ใช้ง่ายใน View
            return (object)[
                'session' => $registration->session,
                'reason' => 'ไม่ผ่านเกณฑ์การเข้าเรียน' // กำหนดเหตุผล
            ];
        });

        return view('certificates.collection', compact('issuedCertificates', 'unissuedCertificates'));
    }

}
