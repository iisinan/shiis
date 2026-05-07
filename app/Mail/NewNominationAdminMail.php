<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Nomination;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewNominationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nominator;
    public $nominee;
    public $position;

    public function __construct(User $nominator, User $nominee, $position)
    {
        $this->nominator = $nominator;
        $this->nominee = $nominee;
        $this->position = $position;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Nomination Received for Review',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-nomination-admin',
        );
    }
}
