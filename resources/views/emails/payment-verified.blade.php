@component('mail::message')
# Payment Verified!

Salam {{ $user->name }},

We are pleased to inform you that your reunion contribution has been verified by our finance team.

**Your account is now fully active.** 

You now have full access to:
- The Class Directory & Member Profiles.
- Executive Nominations (when active).
- Live Election Polls (on reunion day).
- Full Gallery Access.

@component('mail::button', ['url' => route('dashboard')])
Explore the Platform
@endcomponent

Thank you for your commitment to the fraternity. We look forward to seeing you at the reunion!

Stronger Together, Brighter Forever,<br>
**SHIIS '05 Reunion Committee**
@endcomponent
