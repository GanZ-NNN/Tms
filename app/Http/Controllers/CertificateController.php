<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CertificateController extends Controller
{
    // ออกใบรับรอง
    public function generate($userId, $sessionId)
    {
        $user = User::findOrFail($userId);
        $session = TrainingSession::findOrFail($sessionId);

        // สร้าง record
        $certificate = Certificate::create([
            'user_id' => $user->id,
            'session_id' => $session->id,
            'issued_at' => now(),
        ]);

        // ใช้ view template สำหรับ PDF
        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'user' => $user,
            'session' => $session,
            'qrCode' => base64_encode(
                QrCode::format('png')->size(120)->generate(
                    url("/certificate/verify/" . $certificate->verification_hash)
                )
            )
        ]);

        // เก็บไฟล์ลง storage
        $filePath = "certificates/{$certificate->cert_no}.pdf";
        Storage::put($filePath, $pdf->output());

        // update path
        $certificate->update(['pdf_path' => $filePath]);

        return response()->download(storage_path("app/{$filePath}"));
    }

    // Verify
    public function verify($hash)
    {
        $certificate = Certificate::where('verification_hash', $hash)->first();

        if (!$certificate) {
            return response()->json(['status' => 'invalid']);
        }

        return response()->json([
            'status' => 'valid',
            'cert_no' => $certificate->cert_no,
            'user' => $certificate->user->name,
            'course' => $certificate->session->title,
            'issued_at' => $certificate->issued_at,
        ]);
    }
}
