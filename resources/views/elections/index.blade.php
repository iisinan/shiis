<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Voting Center - ' . $election->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <div class="bg-emerald-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-emerald-900/30 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                </div>
                <div class="relative z-10 text-center md:text-left">
                    <h3 class="text-3xl font-bold font-outfit mb-2">{{ $election->title }}</h3>
                    <p class="text-emerald-100/70 italic text-lg">"Your vote is the foundation of our future leadership."</p>
                </div>
                <div class="relative z-10 text-center bg-white/10 backdrop-blur-md px-8 py-4 rounded-3xl border border-white/20">
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-emerald-200 mb-1">Polls Close</p>
                    <p class="text-2xl font-bold font-outfit">{{ \Carbon\Carbon::parse($election->end_date)->format('M j, Y - g:i A') }}</p>
                </div>
            </div>

            @foreach($candidates as $position => $positionCandidates)
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-2 bg-emerald-900 rounded-full"></div>
                        <h3 class="text-2xl font-bold text-emerald-950 font-outfit uppercase tracking-widest">{{ $position }}</h3>
                        @if(in_array($position, $userVotes))
                            <span class="flex items-center gap-2 text-emerald-600 bg-emerald-50 px-4 py-1 rounded-full text-xs font-bold border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Decision Recorded
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($positionCandidates as $candidate)
                            <div class="bg-white rounded-[2rem] p-8 border {{ in_array($position, $userVotes) ? 'opacity-40 grayscale border-emerald-50' : 'border-emerald-100 hover:border-emerald-500 hover:shadow-2xl shadow-emerald-900/5' }} transition-all duration-500 relative group">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-24 h-24 rounded-[2rem] bg-emerald-50 flex items-center justify-center text-emerald-900 text-4xl font-bold mb-6 group-hover:bg-emerald-900 group-hover:text-white transition duration-500 shadow-inner">
                                        {{ substr($candidate->user->name, 0, 1) }}
                                    </div>
                                    <h4 class="text-xl font-bold text-emerald-950 font-outfit">{{ $candidate->user->name }}</h4>
                                    
                                    @if($candidate->manifesto)
                                        <div class="mt-6 bg-emerald-50/50 p-4 rounded-2xl text-sm italic text-emerald-800/70 leading-relaxed border border-emerald-50">
                                            "{{ $candidate->manifesto }}"
                                        </div>
                                    @endif

                                    <div class="mt-8 w-full">
                                        @if(!in_array($position, $userVotes))
                                            <form action="{{ route('elections.vote', $election) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                <button type="submit" class="w-full py-4 bg-emerald-900 hover:bg-emerald-950 text-white font-bold rounded-2xl transition shadow-xl hover:shadow-emerald-900/20" onclick="return confirm('Cast your vote for {{ $candidate->user->name }}?')">
                                                    Cast Vote
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="w-full py-4 bg-emerald-50 text-emerald-200 font-bold rounded-2xl cursor-not-allowed border border-emerald-100">
                                                Locked
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
