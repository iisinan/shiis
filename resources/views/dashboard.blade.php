<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Payment Status -->
            @if(!auth()->user()->is_paid)
            <div class="bg-white border-2 border-amber-100 rounded-3xl p-8 flex flex-col md:flex-row justify-between items-center shadow-xl shadow-amber-900/5">
                <div class="flex items-center gap-6 text-center md:text-left flex-col md:flex-row">
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-amber-900">Verification in Progress</h3>
                        <p class="text-amber-800/70 text-sm">Our finance team is currently reviewing your uploaded bank receipt. Please check back later.</p>
                    </div>
                </div>
                <div class="mt-6 md:mt-0 px-6 py-2 bg-amber-50 text-amber-800 text-xs font-bold rounded-full uppercase tracking-widest border border-amber-100">
                    Awaiting Approval
                </div>
            </div>
            @else
            <div class="bg-emerald-900 rounded-3xl p-8 flex items-center gap-6 shadow-2xl shadow-emerald-900/20 text-white">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white backdrop-blur-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Account Fully Activated</h3>
                    <p class="text-emerald-100/80 text-sm italic">"Salam! Your contribution has been verified. Welcome to the fraternity."</p>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Stats & Announcements -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-sm">
                            <h4 class="text-emerald-600/60 text-xs font-bold uppercase tracking-widest">My Nominations</h4>
                            <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">{{ auth()->user()->nominations()->count() }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-sm">
                            <h4 class="text-emerald-600/60 text-xs font-bold uppercase tracking-widest">Elections Voted</h4>
                            <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">{{ auth()->user()->votes()->count() }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-sm">
                            <h4 class="text-emerald-600/60 text-xs font-bold uppercase tracking-widest">Graduation</h4>
                            <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">2005</p>
                        </div>
                    </div>

                    <!-- Announcements -->
                    @php $announcements = \App\Models\Announcement::where('is_published', true)->latest()->take(2)->get(); @endphp
                    @if($announcements->count() > 0)
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-8 bg-emerald-600 rounded-full"></div>
                            <h3 class="text-2xl font-bold text-emerald-950 font-outfit">Latest Updates</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($announcements as $ann)
                            <div class="p-8 rounded-3xl bg-white border border-emerald-100 shadow-sm hover:shadow-md transition duration-300">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $ann->type == 'important' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                            {{ $ann->type }}
                                        </span>
                                        <h4 class="font-bold text-lg text-emerald-900 mt-2">{{ $ann->title }}</h4>
                                        <p class="mt-2 text-emerald-800/70">{{ $ann->content }}</p>
                                    </div>
                                    <span class="text-xs font-bold text-emerald-600/40 uppercase">{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Profile Overview -->
                    <div class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 opacity-5">
                            <img src="{{ asset('images/logo.png') }}" class="w-64 h-64 grayscale">
                        </div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-10 text-center md:text-left">
                            <div class="w-32 h-32 rounded-[2rem] bg-emerald-900 flex items-center justify-center text-white text-4xl font-bold shadow-2xl border-4 border-emerald-50">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-3xl font-bold font-outfit text-emerald-950">{{ auth()->user()->name }}</h3>
                                <p class="text-emerald-700/60 text-md mt-1">{{ auth()->user()->email }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-emerald-900 underline decoration-dashed underline-offset-4 hover:text-emerald-600">Edit My Profile</a>
                                </div>
                            </div>
                            @unless(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                                <a href="{{ route('nominations.index') }}" class="px-8 py-4 bg-emerald-900 text-white font-bold rounded-2xl text-center hover:bg-emerald-950 transition shadow-xl w-full md:w-auto">
                                    Nominate Peer
                                </a>
                            @endunless
                        </div>
                    </div>

                    <!-- Networking Card -->
                    <div class="bg-emerald-50 rounded-[2.5rem] p-10 border border-emerald-100 flex flex-col md:flex-row items-center justify-between gap-8 group hover:bg-emerald-900 transition duration-700">
                        <div class="flex items-center gap-6">
                            <div class="w-20 h-20 bg-white rounded-[1.5rem] flex items-center justify-center text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-700">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold font-outfit text-emerald-950 group-hover:text-white transition duration-700">Find Your Classmates</h3>
                                <p class="text-emerald-700/60 group-hover:text-emerald-100/60 transition duration-700">Discover where the Class of 2005 is today.</p>
                            </div>
                        </div>
                        <a href="{{ route('members.index') }}" class="px-10 py-4 bg-emerald-900 text-white font-bold rounded-2xl shadow-xl group-hover:bg-white group-hover:text-emerald-900 transition duration-700">
                            Open Directory
                        </a>
                    </div>

                    <!-- Additional Payment Section -->
                    <div class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5" x-data="{ showForm: false }">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-emerald-950 font-outfit">Support the Reunion</h3>
                                    <p class="text-emerald-700/60 text-sm">Make an additional contribution or update payment evidence.</p>
                                </div>
                            </div>
                            <button @click="showForm = !showForm" class="px-8 py-3 bg-emerald-50 text-emerald-900 font-bold rounded-xl border border-emerald-100 hover:bg-emerald-100 transition">
                                <span x-text="showForm ? 'Close Form' : 'Add Payment'"></span>
                            </button>
                        </div>

                        <div x-show="showForm" x-transition class="mt-10 pt-10 border-t border-emerald-50">
                            <form action="{{ route('payment.storeAdditional') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="add_amount" :value="__('Contribution Amount (₦)')" class="text-emerald-900 font-bold" />
                                        <x-text-input id="add_amount" name="amount" type="number" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" required min="1000" placeholder="e.g. 5000" />
                                    </div>
                                    <div>
                                        <x-input-label for="add_receipt" :value="__('Upload Receipt')" class="text-emerald-900 font-bold" />
                                        <input type="file" name="receipt" id="add_receipt" class="mt-1 block w-full text-sm text-emerald-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" required accept="image/*,application/pdf">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <x-primary-button class="bg-emerald-900 hover:bg-emerald-950 px-10 py-3 rounded-xl">
                                        Submit for Verification
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Real-Time Results -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-[2.5rem] border border-emerald-100 shadow-xl shadow-emerald-900/5 overflow-hidden">
                        <div class="p-8 bg-emerald-900 text-white">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold font-outfit">Live Results</h3>
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                            </div>
                            <p class="text-[10px] text-emerald-100/60 uppercase tracking-widest mt-1">Real-time vote counts</p>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            @php
                                $activeElection = \App\Models\Election::where('is_active', true)->first();
                                $results = $activeElection ? \App\Models\Vote::where('election_id', $activeElection->id)
                                    ->select('position', 'candidate_id', \DB::raw('count(*) as total_votes'))
                                    ->groupBy('position', 'candidate_id')
                                    ->with('candidate.user')
                                    ->get()
                                    ->groupBy('position') : collect();
                            @endphp

                            @forelse($results as $pos => $cands)
                                <div>
                                    <h4 class="text-xs font-black text-emerald-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-emerald-900 rounded-full"></span>
                                        {{ $pos }}
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($cands->sortByDesc('total_votes') as $res)
                                            <div class="relative">
                                                <div class="flex justify-between items-center mb-1 text-[11px] font-bold">
                                                    <span class="text-emerald-950">{{ optional($res->candidate->user)->name ?? 'Unknown Candidate' }}</span>
                                                    <span class="text-emerald-900">{{ $res->total_votes }} votes</span>
                                                </div>
                                                <div class="w-full bg-emerald-50 rounded-full h-1.5 overflow-hidden">
                                                    @php 
                                                        $totalPosVotes = $cands->sum('total_votes');
                                                        $percentage = $totalPosVotes > 0 ? ($res->total_votes / $totalPosVotes) * 100 : 0;
                                                    @endphp
                                                    <div class="bg-emerald-600 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10">
                                    <svg class="w-12 h-12 text-emerald-50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-widest leading-relaxed">No votes recorded<br>for active election.</p>
                                </div>
                            @endforelse

                            @unless(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                                <a href="{{ route('elections.index') }}" class="px-8 py-3 bg-emerald-50 text-emerald-900 text-center text-xs font-bold rounded-xl border border-emerald-100 hover:bg-emerald-100 transition">
                                    Cast Your Vote
                                </a>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
