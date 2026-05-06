@component('mail::message')
# Action Required: New Payment Evidence Uploaded

Salam Accountant,

A new member has just registered and uploaded their payment evidence. Please review and verify the transaction to activate their account.

**Member Details:**
- **Name:** {{ $user->name }}
- **Amount Paid:** ₦{{ number_format($payment->amount, 2) }}
- **Reference:** {{ $payment->reference }}
- **Date:** {{ $payment->created_at->format('M d, Y H:i') }}

@component('mail::button', ['url' => route('accountant.dashboard')])
Go to Verification Dashboard
@endcomponent

*Please ensure the receipt matches the contribution amount before activating the member.*

Best Regards,<br>
**SHIIS '05 System**
@endcomponent
