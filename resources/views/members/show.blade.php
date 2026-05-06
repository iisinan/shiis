<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Colleague Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-emerald-100 overflow-hidden">
                <!-- Header / Cover -->
                <div class="h-64 bg-emerald-900 relative">
                    <div class="absolute inset-0 opacity-20">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="0.1" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                    </div>
                    <div class="absolute -bottom-16 left-12">
                        <div class="w-40 h-40 rounded-[2.5rem] bg-white p-2 shadow-2xl">
                            @if($user->profile_photo)
                                <img src="{{ Storage::url($user->profile_photo) }}" class="w-full h-full object-cover rounded-[2rem]">
                            @else
                                <div class="w-full h-full bg-emerald-100 rounded-[2rem] flex items-center justify-center text-emerald-900 text-6xl font-black font-outfit uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($user->is_paid)
                    <div class="absolute bottom-4 right-8">
                        <span class="px-4 py-2 bg-emerald-500/20 backdrop-blur-md border border-white/20 text-white text-[10px] font-black rounded-full uppercase tracking-widest flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            Verified Alumnus
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Profile Info -->
                <div class="pt-24 pb-12 px-12 space-y-12">
                    <div>
                        <h3 class="text-4xl font-extrabold text-emerald-950 font-outfit">{{ $user->name }}</h3>
                        @if($user->nickname)
                            <p class="text-emerald-600 font-bold text-lg italic mt-1">"{{ $user->nickname }}"</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">Current Profession</h4>
                                <p class="text-lg text-emerald-900 font-bold">{{ $user->occupation ?: 'Professional' }}</p>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">Based In</h4>
                                <p class="text-lg text-emerald-900 font-bold">{{ $user->state_country ?: 'Not Specified' }}</p>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">Contact Reference</h4>
                                <p class="text-lg text-emerald-900 font-bold">{{ $user->phone_number ?: 'Contact Privately' }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">About Me</h4>
                                <p class="text-emerald-800/70 leading-relaxed italic">
                                    "{{ $user->biography ?: 'This colleague has not added a bio yet. Look forward to meeting them at the reunion!' }}"
                                </p>
                            </div>
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">Journey at SHIIS</h4>
                                <div class="flex items-center gap-4">
                                    <div class="px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-900 text-sm font-black">
                                        {{ $user->year_admitted ?: '2000' }}
                                    </div>
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <div class="px-4 py-2 bg-emerald-900 rounded-xl text-white text-sm font-black shadow-lg">
                                        {{ $user->year_graduated ?: '2005' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-12 border-t border-emerald-50 flex justify-between items-center">
                        <a href="{{ route('members.index') }}" class="text-sm font-bold text-emerald-900 underline decoration-dashed underline-offset-8 hover:text-emerald-600 transition">Back to Directory</a>
                        <div class="flex gap-4">
                            <a href="mailto:{{ $user->email }}" class="p-4 bg-emerald-50 text-emerald-900 rounded-2xl hover:bg-emerald-900 hover:text-white transition shadow-sm border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
