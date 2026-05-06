<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Election Status') }}
        </h2>
    </x-slot>

    <div class="py-20">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-[2.5rem] p-12 border border-emerald-100 shadow-2xl shadow-emerald-900/5">
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 text-emerald-900 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                
                <h3 class="text-3xl font-bold text-emerald-950 font-outfit mb-4">No Active Elections</h3>
                <p class="text-emerald-700/60 leading-relaxed mb-10">
                    The nomination and voting phases are currently closed. Please stay tuned to the dashboard announcements for updates on the next election cycle.
                </p>

                <div class="space-y-4">
                    <a href="{{ route('dashboard') }}" class="block w-full py-4 bg-emerald-900 hover:bg-emerald-950 text-white font-bold rounded-2xl transition shadow-xl">
                        Return to Dashboard
                    </a>
                    <a href="{{ route('elections.results') }}" class="block w-full py-4 bg-emerald-50 text-emerald-900 font-bold rounded-2xl hover:bg-emerald-100 transition border border-emerald-100">
                        View Past Results
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
