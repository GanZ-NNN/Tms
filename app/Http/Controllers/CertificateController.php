<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;

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

}
