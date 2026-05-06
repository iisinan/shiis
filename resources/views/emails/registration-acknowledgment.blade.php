@component('mail::message')
# Welcome Home, {{ $user->name }}!

Salam! We are thrilled to have you join the official fraternity platform for the **SHIIS Class of 2005 21-Year Reunion**.

We have successfully received your registration and the uploaded payment evidence for **₦{{ number_format($user->payments()->latest()->first()->amount, 2) }}**.

**What Happens Next?**
- Our finance team will review your receipt for verification.
- Once verified, you will receive another email and gain full access to the **Class Directory**, **Nominations**, and **Elections**.
- In the meantime, you can log in to explore the dashboard and set up your personal profile.

@component('mail::button', ['url' => route('dashboard')])
Go to My Dashboard
@endcomponent

*We have attached a copy of your uploaded receipt to this email for your records.*

Stronger Together, Brighter Forever,<br>
**SHIIS '05 Reunion Committee**
@endcomponent
