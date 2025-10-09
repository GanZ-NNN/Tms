<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class CertificateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $certificate;

    public function __construct(User $user, Certificate $certificate)
    {
        $this->user = $user;
        $this->certificate = $certificate;
    }

    public function build()
    {
        $pdfPath = $this->certificate->pdf_path;

        return $this->subject("Your Certificate of Completion")
                    ->markdown('emails.certificate')
                    ->attachData(Storage::get($pdfPath), $this->certificate->cert_no . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
