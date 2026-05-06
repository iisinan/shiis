@component('mail::message')
# Build Your Executive Team

Salam! We are excited to announce that the **Executive Nomination Page** is now officially active.

As we prepare for our 21-year reunion, it is time to select the leaders who will represent the SHIIS Class of 2005.

**What you need to do:**
1. Log in to your dashboard.
2. Visit the **Nominations** section.
3. Select your candidates for the 9 executive roles.

@component('mail::button', ['url' => route('nominations.index')])
Start Nominating Now
@endcomponent

*Note: Nominations are strictly confidential and only verified paid members can participate.*

Stronger Together, Brighter Forever,<br>
**SHIIS '05 Reunion Committee**
@endcomponent
