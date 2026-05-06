<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Mail\RegistrationAcknowledgment;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'min:5000'],
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB max
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Handle Receipt Upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'is_paid' => false,
            'is_active' => false,
        ]);

        // Create Payment Record
        Payment::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'reference' => 'REU-05-' . strtoupper(bin2hex(random_bytes(4))),
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        AuditLogger::log('User Registered', "New user registered: {$user->name} ({$user->email})");

        // Send Acknowledgment Email
        try {
            Mail::to($user->email)->queue(new RegistrationAcknowledgment($user, $receiptPath));
            
            // Notify Accountants
            $accountants = User::role('Accountant')->get();
            $latestPayment = $user->payments()->latest()->first();
            
            foreach ($accountants as $accountant) {
                Mail::to($accountant->email)->queue(new \App\Mail\NewRegistrationForAccountantMail($user, $latestPayment));
            }
        } catch (\Exception $e) {
            // Silently fail if mail fails, or log it
            AuditLogger::log('Email Failure', "Failed to queue registration/accountant notification emails.");
        }

        return redirect(route('dashboard', absolute: false));
    }
}
