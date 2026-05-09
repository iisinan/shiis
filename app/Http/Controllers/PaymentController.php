<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yabacon\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway()
    {
        $user = Auth::user();
        $paystack = new Paystack(config('services.paystack.secretKey'));
        
        try {
            $reference = 'REU-' . time() . '-' . $user->id;
            
            // Amount is in kobo, so 5000 Naira = 500000 kobo
            $tranx = $paystack->transaction->initialize([
                'amount' => 500000,
                'email' => $user->email,
                'reference' => $reference,
                'callback_url' => route('payment.callback'),
            ]);

            // Save pending payment record
            Payment::create([
                'user_id' => $user->id,
                'amount' => 5000.00,
                'reference' => $reference,
                'status' => 'pending',
            ]);

            return redirect($tranx->data->authorization_url);
        } catch (\Exception $e) {
            return back()->with('error', 'The paystack token has expired. Please refresh the page and try again.');
        }
    }

    public function handleGatewayCallback()
    {
        $paystack = new Paystack(config('services.paystack.secretKey'));
        $reference = request('reference');

        if (!$reference) {
            die('No reference supplied');
        }

        try {
            $tranx = $paystack->transaction->verify([
                'reference' => $reference,
            ]);

            if ('success' === $tranx->data->status) {
                $payment = Payment::where('reference', $reference)->first();
                
                if ($payment && $payment->status !== 'success') {
                    $payment->update(['status' => 'success']);
                    
                    // Activate user
                    $user = User::find($payment->user_id);
                    $user->update([
                        'is_paid' => true,
                        'is_active' => true,
                    ]);

                    return redirect()->route('dashboard')->with('success', 'Payment successful and account activated!');
                }
            }

            return redirect()->route('dashboard')->with('error', 'Payment failed or already processed.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $receiptPath = $request->file('receipt')->store('receipts', 'public');

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'reference' => 'REU-ADD-' . strtoupper(bin2hex(random_bytes(4))),
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);

        \App\Services\AuditLogger::log('Additional Payment', Auth::user()->name . " uploaded additional payment evidence of ₦" . number_format($request->amount, 2));

        // Notify Accountants
        try {
            $accountants = User::role('Accountant')->get();
            foreach ($accountants as $accountant) {
                \Illuminate\Support\Facades\Mail::to($accountant->email)->queue(new \App\Mail\NewRegistrationForAccountantMail(Auth::user(), $payment));
            }
        } catch (\Exception $e) {
            // Log failure but proceed
        }

        return back()->with('success', 'Your payment evidence has been uploaded and is awaiting verification.');
    }

    public function accountantDashboard()
    {
        $totalVerifiedAmount = Payment::where('status', 'success')->sum('amount');
        $totalPendingCount = Payment::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'pending')->with('user')->latest()->paginate(10);

        return view('accountant.dashboard', compact('totalVerifiedAmount', 'totalPendingCount', 'pendingPayments'));
    }

    public function verify(Payment $payment)
    {
        try {
            $payment->update(['status' => 'success']);

            // Activate user
            $user = $payment->user;
            if ($user) {
                $user->update([
                    'is_paid' => true,
                    'is_active' => true,
                ]);
            }

            \App\Services\AuditLogger::log('Payment Verification', "Accountant approved payment of ₦" . number_format($payment->amount, 2) . " for " . ($user->name ?? 'Unknown'));

            return back()->with('success', 'Payment verified successfully. Member account is now active.');
        } catch (\Exception $e) {
            return back()->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }

    public function export()
    {
        // Simple CSV export
        $payments = Payment::where('status', 'success')->with('user')->get();
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=financial_report.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($payments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Member Name', 'Email', 'Amount (NGN)', 'Reference']);

            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->created_at->format('Y-m-d'),
                    $payment->user->name,
                    $payment->user->email,
                    $payment->amount,
                    $payment->reference
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
