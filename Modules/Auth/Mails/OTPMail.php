<?php

namespace Modules\Auth\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $otp_code;
    protected $full_name;
    /**
     * Create a new message instance.
     */
    public function __construct($otp_code, $full_name)
    {
        $this->otp_code = $otp_code;
        $this->full_name = $full_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth::Mails.OTP',
            with: [
                'otp_code' => $this->otp_code,
                'name' => $this->full_name,
            ],
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
