<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\TrainingSession;
use App\Models\User;


class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $session;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, TrainingSession $session)
    {
        $this->user = $user;
        $this->session = $session;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Registration Success Mai',
    //     );
    // }

    public function build()
    {
        return $this->subject('ยืนยันการลงทะเบียนอบรมสำเร็จ')
                    ->view('emails.registration_success');
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
