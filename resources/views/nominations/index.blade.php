<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Executive Team Nominations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-emerald-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-5 h-full min-h-[700px]">
                    
                    <!-- Left: Instructions & Branding -->
                    <div class="lg:col-span-2 bg-emerald-900 p-12 text-white relative flex flex-col justify-between overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 opacity-10">
                            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45L18.8 19H5.2L12 5.45zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
                        </div>
                        
                        <div class="relative z-10">
                            <span class="inline-block py-1 px-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-200 mb-8">
                                Leadership Structure 2026
                            </span>
                            <h3 class="text-4xl font-extrabold font-outfit mb-6 leading-tight">Build the Perfect <br>Executive Team</h3>
                            <p class="text-emerald-100/70 text-lg leading-relaxed italic">
                                "The strength of the team is each individual member. The strength of each member is the team."
                            </p>
                        </div>

                        <div class="relative z-10 mt-12 space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-bold text-sm">1</div>
                                <p class="text-sm text-emerald-100/80">Select one nominee for each executive position listed.</p>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-bold text-sm">2</div>
                                <p class="text-sm text-emerald-100/80">You can leave a position blank if you don't have a candidate yet.</p>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-bold text-sm">3</div>
                                <p class="text-sm text-emerald-100/80">Submit the entire form once you are satisfied with your selections.</p>
                            </div>
                        </div>

                        <div class="mt-20 pt-12 border-t border-white/10 relative z-10">
                            <div class="flex items-center gap-4 text-emerald-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-xs font-bold uppercase tracking-widest">Nominations are confidential</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Unified Form -->
                    <div class="lg:col-span-3 p-12 bg-white">
                        <form action="{{ route('nominations.store') }}" method="POST" class="space-y-8">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                @foreach($positions as $pos)
                                    @php 
                                        $existing = $myNominations[$pos] ?? null;
                                        $isLocked = $existing && $existing->status !== 'pending';
                                    @endphp
                                    
                                    <div class="space-y-2">
                                        <label class="flex justify-between items-center px-1">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-900/50">{{ $pos }}</span>
                                            @if($isLocked)
                                                <span class="text-[8px] font-bold text-emerald-500 uppercase tracking-tighter bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Approved</span>
                                            @endif
                                        </label>
                                        
                                        <div class="relative group">
                                            <select name="nominees[{{ $pos }}]" 
                                                    class="block w-full bg-emerald-50/50 border-emerald-100 focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 rounded-2xl text-sm text-emerald-950 font-bold transition duration-300 {{ $isLocked ? 'opacity-60 pointer-events-none' : '' }}"
                                                    {{ $isLocked ? 'disabled' : '' }}>
                                                <option value="">-- Choose Candidate --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ ($existing && $existing->nominee_id == $user->id) ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            @if($existing && !$isLocked)
                                                <div class="absolute -right-2 -top-2">
                                                    <div class="w-5 h-5 bg-emerald-900 text-white rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-12 border-t border-emerald-50">
                                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                    <div class="text-sm text-emerald-600/60 font-medium italic">
                                        * You can update your selections at any time until they are approved.
                                    </div>
                                    <button type="submit" class="w-full md:w-auto px-12 py-5 bg-emerald-900 hover:bg-emerald-950 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-2xl transition transform hover:-translate-y-1 active:scale-95">
                                        Save All Nominations
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Participation Summary -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 bg-emerald-50 rounded-[2rem] border border-emerald-100 flex items-center gap-6">
                    <div class="p-4 bg-white rounded-2xl shadow-sm text-emerald-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest">Completed</p>
                        <p class="text-2xl font-bold text-emerald-950 font-outfit">{{ $myNominations->count() }} / {{ count($positions) }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
