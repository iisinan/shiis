@component('mail::message')
# Welcome Home, {{ $user->name }}!

Salam! We are thrilled to have you join the official platform for the **SHIIS Class of 2005 21-Year Reunion**.

Your registration was successful. You are now one step closer to reconnecting with old friends and making new memories.

**Next Steps:**
1. If you haven't already, please upload your payment evidence on the dashboard.
2. Complete your profile with a photo and bio so classmates can recognize you.
3. Keep an eye on the countdown for nomination and election dates!

@component('mail::button', ['url' => route('dashboard')])
Go to My Dashboard
@endcomponent

Stronger Together, Brighter Forever,<br>
**SHIIS '05 Reunion Committee**
@endcomponent
