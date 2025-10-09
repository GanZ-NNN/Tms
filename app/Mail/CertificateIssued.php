<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificateIssued extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        return $this->subject('Your Training Certificate')
            ->markdown('emails.certificates.issued')
            ->attach(Storage::path($this->certificate->pdf_path), [
                'as' => "{$this->certificate->cert_no}.pdf",
                'mime' => 'application/pdf',
            ]);
    }
}
