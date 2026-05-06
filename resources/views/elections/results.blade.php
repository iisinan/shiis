<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Election Results - ' . $election->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center">
                <span class="inline-block px-4 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100 uppercase tracking-widest mb-4">Official Declaration</span>
                <h3 class="text-4xl font-extrabold text-emerald-950 font-outfit">Election Outcome</h3>
                <p class="mt-2 text-emerald-700/60 font-medium">Finalized on {{ $election->end_date->format('M d, Y') }}</p>
            </div>

            @foreach($results as $position => $candidates)
                @php 
                    $winner = $candidates->sortByDesc('total_votes')->first();
                @endphp
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-2 bg-emerald-900 rounded-full"></div>
                        <h4 class="text-2xl font-bold text-emerald-950 font-outfit uppercase tracking-wider">{{ $position }}</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($candidates->sortByDesc('total_votes') as $res)
                            @php $isWinner = $res->candidate_id === $winner->candidate_id; @endphp
                            <div class="bg-white rounded-[2.5rem] p-8 border {{ $isWinner ? 'border-emerald-500 shadow-2xl shadow-emerald-900/10' : 'border-emerald-100 shadow-sm' }} relative overflow-hidden transition-all duration-500">
                                @if($isWinner)
                                    <div class="absolute top-0 right-0">
                                        <div class="bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.2em] px-8 py-2 rotate-45 translate-x-8 translate-y-3 shadow-lg">
                                            Elected
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center gap-6">
                                    <div class="w-20 h-20 rounded-3xl bg-emerald-50 flex items-center justify-center text-emerald-900 text-3xl font-bold shadow-inner border border-emerald-100">
                                        {{ substr($res->candidate->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="text-xl font-bold text-emerald-950 font-outfit">{{ $res->candidate->user->name }}</h5>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="text-3xl font-black text-emerald-900 font-outfit">{{ $res->total_votes }}</span>
                                            <span class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">Votes</span>
                                        </div>
                                    </div>
                                </div>

                                @if($isWinner)
                                    <div class="mt-8 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mb-1">Status</p>
                                        <p class="text-sm font-bold text-emerald-900 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Inauguration Pending
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-12 text-center p-12 bg-emerald-900 rounded-[3rem] text-white shadow-2xl shadow-emerald-950/20">
                <h4 class="text-2xl font-bold font-outfit mb-4">Congratulations to the Elects!</h4>
                <p class="text-emerald-100/70 text-sm max-w-2xl mx-auto italic leading-relaxed">
                    "We thank all candidates for their courage and dedication to the SHIIS Class of 2005. May this new leadership guide our fraternity to greater heights of unity and progress."
                </p>
                <div class="mt-10">
                    <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-white text-emerald-900 font-bold rounded-2xl hover:bg-emerald-50 transition shadow-xl inline-block">
                        Back to Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
