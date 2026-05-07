<x-mail::message>
# Congratulations, {{ $user->name }}!

We are pleased to inform you that your nomination for the position of **{{ $position }}** in the upcoming Class of 2005 Reunion elections has been reviewed and **approved** by the electoral committee.

You are now an official candidate! 

<x-mail::button :url="route('dashboard')">
View Dashboard
</x-mail::button>

We wish you the best of luck in the upcoming elections.

Best regards,  
SHIIS '05 Reunion Committee
</x-mail::message>
