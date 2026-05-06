<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\AuditLog;
use App\Mail\NominationActiveMail;
use App\Mail\ElectionActiveMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendEventNotifications extends Command
{
    protected $signature = 'app:send-event-notifications';
    protected $description = 'Sends email notifications when nominations or elections become active.';

    public function handle()
    {
        $today = now()->format('Y-m-d');
        $nominationDay = '2026-05-30';
        $electionDay = '2026-05-31';

        // 1. Check for Nomination Activation
        if ($today === $nominationDay) {
            $this->sendNotification('nomination_active_email', NominationActiveMail::class, 'Executive Nominations');
        }

        // 2. Check for Election Activation
        if ($today === $electionDay) {
            $this->sendNotification('election_active_email', ElectionActiveMail::class, 'Election Polls');
        }
    }

    private function sendNotification($logAction, $mailableClass, $humanTitle)
    {
        // Check if we already sent this today to prevent duplicates
        $alreadySent = AuditLog::where('action', $logAction)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($alreadySent) {
            $this->info("{$humanTitle} notification already sent today.");
            return;
        }

        $members = User::where('is_paid', true)->get();
        
        $this->info("Sending {$humanTitle} notification to {$members->count()} verified members...");

        foreach ($members as $member) {
            try {
                Mail::to($member->email)->queue(new $mailableClass());
            } catch (\Exception $e) {
                $this->error("Failed to send to {$member->email}: " . $e->getMessage());
            }
        }

        // Log the event
        AuditLog::create([
            'user_id' => null, // System action
            'action' => $logAction,
            'description' => "System automatically broadcasted {$humanTitle} activation emails to all verified members.",
            'ip_address' => '127.0.0.1'
        ]);

        $this->info("{$humanTitle} notifications queued successfully.");
    }
}
