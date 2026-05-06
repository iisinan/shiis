<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Nomination Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-emerald-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-emerald-900/30 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45L18.8 19H5.2L12 5.45zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"/></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold font-outfit mb-2">Executive Candidate Review</h3>
                    <p class="text-emerald-100/70 italic text-lg">"Evaluate the nominations and approve candidates for the live election."</p>
                </div>
                <div class="relative z-10 bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20 text-center">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-emerald-200">Pending</span>
                    <div class="text-2xl font-bold font-outfit">{{ $nominations->where('status', 'pending')->count() }}</div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-100">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-emerald-50">
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Position</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Nominee</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Nominator</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($nominations as $nom)
                                    <tr class="hover:bg-emerald-50/30 transition group">
                                        <td class="py-6 px-4">
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-100 uppercase tracking-widest">
                                                {{ $nom->position }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-900 font-bold shadow-inner">
                                                    {{ substr($nom->nominee->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-emerald-950">{{ $nom->nominee->name }}</div>
                                                    <div class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-tighter">{{ $nom->nominee->occupation ?: 'Professional' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-4">
                                            <div class="text-sm text-emerald-800 font-medium">{{ $nom->nominator->name }}</div>
                                            <p class="text-[10px] text-emerald-600/40 font-bold uppercase mt-1">{{ $nom->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="py-6 px-4 text-right">
                                            @if($nom->status === 'pending')
                                                <form action="{{ route('admin.nominations.approve', $nom) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-6 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-[10px] font-bold rounded-xl transition shadow-lg transform hover:-translate-y-0.5 active:scale-95" onclick="return confirm('Approve this nomination and create candidate profile?')">
                                                        Approve Candidate
                                                    </button>
                                                </form>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-100 uppercase tracking-widest">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    {{ ucfirst($nom->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-20 text-center text-emerald-200 italic font-bold uppercase tracking-widest">No nominations submitted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
