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
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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

        if (!$session->eligibleForCertificate($user)) {
            \Log::info("User {$user->id} not eligible for certificate for session {$session->id}");
            return;
        }

        \DB::transaction(function () use ($user, $session) {
            $cert_no = 'CERT-' . strtoupper(uniqid());
            $verification_hash = md5(uniqid());
            $issued_at = now(); // <-- สร้างตัวแปร issued_at
            $path = "certificates/{$cert_no}.pdf";

            $pdf = PDF::loadView('certificates.pdf', [
                'user' => $user,
                'session' => $session,
                'cert_no' => $cert_no,
                'qr' => QrCode::size(100)->generate(route('certificates.verify.hash', $verification_hash)),
                'issued_at' => $issued_at, // <-- ส่งเข้า view
            ]);

            Storage::put($path, $pdf->output());

            Certificate::updateOrCreate(
                ['user_id' => $user->id, 'session_id' => $session->id],
                [
                    'issued_at' => $issued_at,
                    'cert_no' => $cert_no,
                    'verification_hash' => $verification_hash,
                    'pdf_path' => $path,
                    'issued_at' => $issued_at,
                ]
            );
        });

    } catch (\Exception $e) {
        \Log::error("IssueCertificateJob failed: " . $e->getMessage());
        throw $e;
    }
}


}
