<x-mail::message>
# New Nomination for Review

A new nomination has been submitted for the upcoming elections.

**Position:** {{ $position }}  
**Nominee:** {{ $nominee->name }} ({{ $nominee->email }})  
**Nominator:** {{ $nominator->name }}

Please review the nomination in the admin panel to approve or reject the candidate.

<x-mail::button :url="route('admin.nominations')">
Review Nominations
</x-mail::button>

Thanks,  
SHIIS '05 System
</x-mail::message>
