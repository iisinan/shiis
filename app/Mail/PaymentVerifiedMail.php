<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;
    use \Illuminate\Mail\Mailables\Attachment;

    public function __construct(public User $user, public ?\App\Models\Payment $payment = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SHIIS \'05: Your Payment has been Verified!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-verified',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->payment && $this->payment->receipt_path) {
            $disk = config('filesystems.default');
            $path = $this->payment->receipt_path;
            
            if (\Illuminate\Support\Facades\Storage::disk($disk)->exists($path)) {
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk($disk, $path)
                    ->as('reunion_receipt_' . $this->payment->reference . '.' . pathinfo($path, PATHINFO_EXTENSION));
            }
        }

        return $attachments;
    }
}
