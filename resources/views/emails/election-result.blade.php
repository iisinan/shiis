<x-mail::message>
# Election Results Announced!

Salam! The **{{ $election->title }}** has officially concluded and the results have been finalized. 

Thank you to everyone who participated in shaping the future leadership of the SHIIS Class of 2005.

### Final Results:

@foreach($results as $position => $candidates)
**{{ $position }}**
@foreach($candidates->sortByDesc('total_votes') as $index => $res)
{{ $index === 0 ? '🏆' : '▫️' }} {{ optional($res->candidate->user)->name ?? 'Unknown' }} - {{ $res->total_votes }} votes
@endforeach

@endforeach

Congratulations to all the newly elected executives!

<x-mail::button :url="route('dashboard')">
View Full Details on Dashboard
</x-mail::button>

Best regards,<br>
The Electoral Committee<br>
{{ config('app.name') }}
</x-mail::message>
