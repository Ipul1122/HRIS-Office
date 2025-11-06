<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp; // Buat properti publik untuk OTP

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp)
    {
        $this->otp = $otp; // Terima OTP saat Mailable dibuat
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Reset Password Anda', // Judul Email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Kita akan gunakan view 'emails.otp'
        return new Content(
            view: 'emails.otp',
        );
    }
}