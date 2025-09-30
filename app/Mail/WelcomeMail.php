<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // ส่งข้อมูล user ไป view

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user; // เก็บ user ไว้ใช้ใน view
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('ยินดีต้อนรับสู่ระบบของเรา')
                    ->markdown('emails.welcome'); // ใช้ markdown view
    }
}
