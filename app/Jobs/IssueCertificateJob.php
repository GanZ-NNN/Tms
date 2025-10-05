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
use PDF;
use QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        $user = $this->user;
        $session = $this->session;

        // ตรวจสอบเงื่อนไข eligibility
        if (!$session->eligibleForCertificate($user)) {
            return;
        }

        DB::transaction(function () use ($user, $session) {
            // สร้าง cert_no และ verification_hash
            $cert_no = 'CERT-' . strtoupper(uniqid());
            $verification_hash = md5(uniqid());
            $path = "certificates/{$cert_no}.pdf";

            // สร้าง PDF ก่อน
            $pdf = PDF::loadView('certificates.pdf', [
                'user' => $user,
                'session' => $session,
                'cert_no' => $cert_no,
                'qr' => QrCode::size(100)->generate(route('certificates.verify.hash', $verification_hash))
            ]);

            Storage::put($path, $pdf->output());

            // สร้างหรืออัปเดต Certificate ใน DB พร้อม pdf_path
            Certificate::updateOrCreate(
                ['user_id' => $user->id, 'session_id' => $session->id],
                [
                    'issued_at' => now(),
                    'cert_no' => $cert_no,
                    'verification_hash' => $verification_hash,
                    'pdf_path' => $path,
                ]
            );
        });
    }
}
