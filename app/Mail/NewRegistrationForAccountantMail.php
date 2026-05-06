<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegistrationForAccountantMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Payment $payment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ALERT: New Registration Payment Pending Verification',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.accountant-notification',
        );
    }
}
