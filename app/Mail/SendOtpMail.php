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

    // 1. Tambahkan variabel public untuk menyimpan kode
    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct($code) // 2. Tangkap kode dari Controller
    {
        $this->code = $code; // 3. Simpan ke variabel public
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope 
    {
        return new Envelope(subject: 'Kode Verifikasi NONGKI Coffee');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content 
    {
        return new Content(
            view: 'emails.otp',
            with: ['code' => $this->code],
        );
    }

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