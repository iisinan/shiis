<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Admin Control Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Admin Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                    <h4 class="text-emerald-600/60 text-[10px] font-bold uppercase tracking-widest">Total Members</h4>
                    <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                    <h4 class="text-emerald-600/60 text-[10px] font-bold uppercase tracking-widest">Paid & Verified</h4>
                    <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">{{ \App\Models\User::where('is_paid', true)->count() }}</p>
                </div>
                <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                    <h4 class="text-emerald-600/60 text-[10px] font-bold uppercase tracking-widest">Active Election</h4>
                    <p class="text-4xl font-bold text-emerald-900 mt-2 font-outfit">{{ \App\Models\Election::where('is_active', true)->count() }}</p>
                </div>
                <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                    <h4 class="text-emerald-600/60 text-[10px] font-bold uppercase tracking-widest">Pending Verification</h4>
                    <p class="text-4xl font-bold text-amber-600 mt-2 font-outfit">{{ \App\Models\User::where('is_paid', false)->count() }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Administrative Actions -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                        <h3 class="text-2xl font-bold text-emerald-950 font-outfit mb-8">Management Suite</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <a href="{{ route('admin.members') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Member Verification</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Review Receipts</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.nominations') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Nominations</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Review Candidates</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.agenda.index') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Agenda Builder</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Manage Schedule</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.gallery.index') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Gallery Media</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Upload Photos</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.logs') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Activity Logs</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Audit History</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.announcements.index') }}" class="group p-6 bg-emerald-50 rounded-[2rem] border border-emerald-100 hover:bg-emerald-900 transition duration-500">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white rounded-2xl text-emerald-900 shadow-sm group-hover:bg-emerald-800 group-hover:text-white transition duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-900 group-hover:text-white transition duration-500">Broadcast Center</h4>
                                        <p class="text-[10px] text-emerald-600/50 uppercase tracking-widest group-hover:text-emerald-100/50 transition duration-500">Manage Updates</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Live Election Control & Results -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-[2.5rem] border border-emerald-100 shadow-xl shadow-emerald-900/5 overflow-hidden">
                        <div class="p-8 bg-emerald-900 text-white">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold font-outfit">Election Hub</h3>
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                            </div>
                            <p class="text-[10px] text-emerald-100/60 uppercase tracking-widest mt-1">Real-time vote Monitoring</p>
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
                                                    <span class="text-emerald-950">{{ $res->candidate->user->name }}</span>
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
                                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-widest leading-relaxed">No votes monitored<br>for active election.</p>
                                </div>
                            @endforelse

                            @if($activeElection)
                                <form action="{{ route('admin.elections.toggle', $activeElection) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full py-3 bg-red-50 text-red-600 text-center text-xs font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition" onclick="return confirm('Are you sure you want to CLOSE the election and broadcast results? This cannot be undone easily.')">
                                        Close Election & Broadcast Results
                                    </button>
                                </form>
                            @else
                                @php
                                    $inactiveElection = \App\Models\Election::where('is_active', false)->latest()->first();
                                @endphp
                                @if($inactiveElection)
                                    <form action="{{ route('admin.elections.toggle', $inactiveElection) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full py-3 bg-emerald-50 text-emerald-600 text-center text-xs font-bold rounded-xl border border-emerald-100 hover:bg-emerald-600 hover:text-white transition" onclick="return confirm('Are you sure you want to OPEN the election for voting?')">
                                            Open Election
                                        </button>
                                    </form>
                                @endif
                            @endif

                            <div class="mt-8 pt-8 border-t border-emerald-100">
                                <h4 class="text-xs font-black text-emerald-900 uppercase tracking-widest mb-4">Nomination Controls</h4>
                                @php
                                    $nomsActive = \Illuminate\Support\Facades\Cache::get('nominations_active', false);
                                @endphp
                                <form action="{{ route('admin.nominations.toggle') }}" method="POST">
                                    @csrf
                                    @if($nomsActive)
                                        <button type="submit" class="block w-full py-3 bg-amber-50 text-amber-600 text-center text-xs font-bold rounded-xl border border-amber-100 hover:bg-amber-600 hover:text-white transition" onclick="return confirm('Are you sure you want to deactivate nominations?')">
                                            Deactivate Nominations
                                        </button>
                                    @else
                                        <button type="submit" class="block w-full py-3 bg-emerald-50 text-emerald-600 text-center text-xs font-bold rounded-xl border border-emerald-100 hover:bg-emerald-600 hover:text-white transition" onclick="return confirm('Are you sure you want to activate nominations?')">
                                            Activate Nominations
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
