<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ElectionActiveMail extends Mailable
{
    use Queueable, SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SHIIS \'05: Election Polls are NOW OPEN! Cast Your Vote.',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.elections-active',
        );
    }
}
