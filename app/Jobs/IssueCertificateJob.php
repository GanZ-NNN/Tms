<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\CertificateMail;


class IssueCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $session;

    public function __construct(User $user, TrainingSession $session)
    {
        $this->user = $user;
        $this->session = $session;
    }

public function handle()
    {
        try {
            $user = $this->user;
            $session = $this->session;

            // ตรวจสอบ attendance + feedback
            if (!$session->eligibleForCertificate($user)) {
                Log::info("User {$user->id} not eligible for certificate for session {$session->id}");
                return;
            }

            DB::transaction(function () use ($user, $session) {

                $cert_no = 'CERT-' . strtoupper(uniqid());
                $verification_hash = md5(uniqid());
                $issued_at = now();
                $pdfPath = "certificates/{$cert_no}.pdf";

                // --- *** ส่วนที่แก้ไขทั้งหมด *** ---

                // 1. สร้าง QR Code ด้วยวิธีที่เรียบง่ายและถูกต้อง
                $verificationUrl = route('certificates.verify.hash', $verification_hash);
                $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(150)->generate($verificationUrl);
                $qrCodeBase64 = base64_encode($qrImage);

                // --- สิ้นสุดส่วน QR Code ---


                // Logo / Signature
                $logoPath = public_path('images/logo.png');
                $signaturePath = public_path('images/signature.png');
                $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
                $signatureBase64 = file_exists($signaturePath) ? base64_encode(file_get_contents($signaturePath)) : null;

                // PDF
                $pdf = PDF::loadView('certificates.template', [
                    'user' => $user,
                    'session' => $session,
                    'cert_no' => $cert_no,
                    'qrCodeBase64' => $qrCodeBase64,
                    'logoBase64' => $logoBase64,
                    'signatureBase64' => $signatureBase64,
                    'issued_at' => $issued_at,
                ])->setPaper('a4', 'landscape');
                    
                Storage::put($pdfPath, $pdf->output());

                // สร้าง/อัปเดต Certificate Record
                $certificate = Certificate::updateOrCreate(
                    ['user_id' => $user->id, 'session_id' => $session->id],
                    [
                        'cert_no' => $cert_no,
                        'verification_hash' => $verification_hash,
                        'pdf_path' => $pdfPath,
                        'issued_at' => $issued_at,
                    ]
                );

                // ส่ง Email แนบ PDF
                Mail::to($user->email)->queue(new CertificateMail($user, $certificate));
            });

        } catch (\Exception $e) {
            Log::error("IssueCertificate-Job failed for user {$this->user->id} and session {$this->session->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
