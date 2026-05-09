<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentVerifiedMail;

class AccountantController extends Controller
{
    public function dashboard()
    {
        $pendingPayments = Payment::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        $totalVerifiedAmount = Payment::where('status', 'success')->sum('amount');
        $totalPendingCount = Payment::where('status', 'pending')->count();

        return view('accountant.dashboard', compact('pendingPayments', 'totalVerifiedAmount', 'totalPendingCount'));
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'success']);
        
        $user = $payment->user;
        
        // Ensure user is activated if this is their first payment
        if (!$user->is_paid) {
            $user->update([
                'is_paid' => true,
                'is_active' => true,
            ]);
        }

        AuditLogger::log('Payment Verified', "Accountant verified payment of ₦" . number_format($payment->amount, 2) . " for {$user->name}");

        // Send confirmation email to member
        try {
            Mail::to($user->email)->send(new PaymentVerifiedMail($user, $payment));
        } catch (\Exception $e) {
            AuditLogger::log('Email Failure', "Failed to send activation email to {$user->email}");
        }

        return back()->with('success', "Payment for {$user->name} has been verified successfully.");
    }

    public function exportVerifiedPayments()
    {
        $payments = Payment::with('user')->where('status', 'success')->get();
        $csvFileName = 'verified_payments_' . date('Y-m-d_H-i') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Date', 'Member Name', 'Email', 'Amount (NGN)', 'Reference'];

        $callback = function() use($payments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($payments as $payment) {
                $row['Date']    = $payment->updated_at->format('Y-m-d H:i');
                $row['Name']    = $payment->user->name;
                $row['Email']   = $payment->user->email;
                $row['Amount']  = $payment->amount;
                $row['Ref']     = $payment->reference;

                fputcsv($file, [$row['Date'], $row['Name'], $row['Email'], $row['Amount'], $row['Ref']]);
            }

            fclose($file);
        };

        AuditLogger::log('Financial Export', "Accountant exported verified payments report.");

        return response()->stream($callback, 200, $headers);
    }
}
