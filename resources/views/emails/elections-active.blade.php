@component('mail::message')
# The Ballot is Open!

The moment has arrived. The **SHIIS Class of 2005 Election Polls** are now officially open.

Your voice is the foundation of our fraternity's leadership. Please take a moment to cast your vote for the approved candidates.

**Election Details:**
- **Status:** LIVE
- **Requirement:** Verified Paid Membership
- **Deadline:** Polls close at the end of the reunion session today.

@component('mail::button', ['url' => route('elections.index')])
Cast Your Vote Now
@endcomponent

*Make your choice count. Let us elect leaders who will carry our legacy forward.*

Stronger Together, Brighter Forever,<br>
**SHIIS '05 Reunion Committee**
@endcomponent
