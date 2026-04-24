<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Member $member,
        public string $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restablece tu contraseña - PEQ Cakes'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member-password-reset'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
