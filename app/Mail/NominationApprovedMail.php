<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NominationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $position;

    public function __construct(User $user, $position)
    {
        $this->user = $user;
        $this->position = $position;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Congratulations! Your Nomination has been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.nomination-approved',
        );
    }
}
