<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Audit Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-100">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-emerald-50">
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Timestamp</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">User</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Action</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Description</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">IP Address</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-emerald-50/30 transition text-sm">
                                        <td class="py-6 px-4 text-emerald-700 font-bold whitespace-nowrap">{{ $log->created_at->format('M d, H:i') }}</td>
                                        <td class="py-6 px-4">
                                            <div class="font-bold text-emerald-950">{{ $log->user->name ?? 'Guest' }}</div>
                                            <div class="text-[10px] text-emerald-600/50 font-bold">{{ $log->user->email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-6 px-4">
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-100 uppercase tracking-widest">
                                                {{ $log->action }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-4 text-emerald-800/70">
                                            {{ $log->description }}
                                        </td>
                                        <td class="py-6 px-4 text-[10px] font-mono text-emerald-300">
                                            {{ $log->ip_address }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-20 text-center text-emerald-200 italic font-bold uppercase tracking-widest">No logs recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
