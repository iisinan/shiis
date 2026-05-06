<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Class Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Search & Filter -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                <form action="{{ route('members.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, nickname or occupation..." class="block w-full pl-12 pr-4 py-4 bg-emerald-50/30 border-emerald-50 focus:ring-emerald-500 focus:bg-white rounded-2xl text-emerald-900 font-medium transition duration-300">
                    </div>
                    <button type="submit" class="px-10 py-4 bg-emerald-900 text-white font-bold rounded-2xl shadow-lg hover:bg-emerald-950 transition">
                        Find Colleague
                    </button>
                </form>
            </div>

            <!-- Members Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($members as $member)
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-100 group hover:-translate-y-2 transition duration-500">
                        <div class="relative h-48 bg-emerald-900 flex items-center justify-center overflow-hidden">
                            @if($member->profile_photo)
                                <img src="{{ Storage::url($member->profile_photo) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-700">
                            @else
                                <div class="text-white/20 text-7xl font-black font-outfit uppercase">{{ substr($member->name, 0, 1) }}</div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-6">
                                <h3 class="text-white font-bold font-outfit text-xl">{{ $member->name }}</h3>
                                <p class="text-emerald-400 text-[10px] font-black uppercase tracking-widest">{{ $member->nickname ?: 'Classmate' }}</p>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="space-y-1">
                                <p class="text-[10px] text-emerald-600/50 font-black uppercase tracking-widest">Profession</p>
                                <p class="text-sm text-emerald-900 font-bold truncate">{{ $member->occupation ?: 'General Professional' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-emerald-600/50 font-black uppercase tracking-widest">Location</p>
                                <p class="text-sm text-emerald-900 font-bold truncate">{{ $member->state_country ?: 'Resident Member' }}</p>
                            </div>
                            
                            <a href="{{ route('members.show', $member) }}" class="block w-full py-3 bg-emerald-50 text-emerald-900 text-center text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-900 hover:text-white transition shadow-sm border border-emerald-100">
                                View Profile
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center">
                        <div class="w-24 h-24 bg-emerald-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-emerald-200">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-emerald-800/40 font-black uppercase tracking-[0.2em]">No classmates found</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
