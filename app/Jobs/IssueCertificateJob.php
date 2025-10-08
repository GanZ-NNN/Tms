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
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class IssueCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $session;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, TrainingSession $session)
    {
        $this->user = $user;
        $this->session = $session;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $user = $this->user;
            $session = $this->session;

            // ตรวจสอบสิทธิ์ก่อนออกใบประกาศ
            if (!$session->eligibleForCertificate($user)) {
                Log::info("User {$user->id} not eligible for certificate for session {$session->id}");
                return;
            }

            DB::transaction(function () use ($user, $session) {

                $cert_no = 'CERT-' . strtoupper(uniqid());
                $verification_hash = md5(uniqid());
                $issued_at = now();
                $path = "certificates/{$cert_no}.pdf";

                // สร้างหรืออัปเดต certificate record
                $certificate = Certificate::updateOrCreate(
                    ['user_id' => $user->id, 'session_id' => $session->id],
                    [
                        'cert_no' => $cert_no,
                        'verification_hash' => $verification_hash,
                        'pdf_path' => $path,
                        'issued_at' => $issued_at,
                    ]
                );

                // Generate QR Code using chillerlan/php-qrcode
                $options = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                    'eccLevel' => QRCode::ECC_H,
                    'scale' => 5,
                    'imageBase64' => false,
                ]);

                $qrcode = new QRCode($options);
                $qrCodeBase64 = base64_encode(
                    $qrcode->render(route('certificates.verify.hash', $verification_hash))
                );

                // Generate PDF
                $pdf = Pdf::loadView('certificates.template', [
                    'user' => $user,
                    'session' => $session,
                    'certificate' => $certificate,
                    'qrCodeBase64' => $qrCodeBase64
                ])->setPaper('a4', 'landscape');


                // บันทึก PDF ลง Storage
                Storage::put($path, $pdf->output());

                // อัปเดต pdf_path ในฐานข้อมูล
                $certificate->update(['pdf_path' => $path]);
            });

        } catch (\Exception $e) {
            Log::error("IssueCertificateJob failed: " . $e->getMessage());
            throw $e;
        }
    }
}
