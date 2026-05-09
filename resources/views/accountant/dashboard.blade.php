<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Accountant Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        showReceipt: false, 
        receiptUrl: '', 
        currentMember: '',
        openReceipt(url, name) {
            this.receiptUrl = url;
            this.currentMember = name;
            this.showReceipt = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Financial Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Total Verified -->
                <div class="bg-emerald-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-emerald-900/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-200">Total Verified Funds</span>
                        <div class="text-4xl font-black font-outfit mt-2">₦{{ number_format($totalVerifiedAmount, 2) }}</div>
                        <div class="mt-6 flex flex-wrap gap-4">
                            <a href="{{ route('accountant.export') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-white text-emerald-900 text-[10px] font-bold rounded-xl hover:bg-emerald-50 transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Financial Report (.CSV)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pending Actions -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5 relative overflow-hidden">
                    <div class="relative z-10">
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-600/40">Pending Verifications</span>
                        <div class="text-4xl font-black font-outfit mt-2 text-emerald-900">{{ $totalPendingCount }}</div>
                        <div class="mt-4 flex items-center gap-2">
                            <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                            <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">Awaiting Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Queue -->
            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-100">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-emerald-950 font-outfit mb-6">Payment Verification Queue</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-emerald-50">
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Member</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Contribution</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Evidence</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($pendingPayments as $payment)
                                    @php $member = $payment->user; @endphp
                                    <tr class="hover:bg-emerald-50/30 transition group">
                                        <td class="py-6 px-4">
                                            <div class="font-bold text-emerald-950">{{ $member->name }}</div>
                                            <div class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-tighter">{{ $member->email }}</div>
                                        </td>
                                        <td class="py-6 px-4 text-sm font-black text-emerald-900 font-outfit">
                                            ₦{{ number_format($payment->amount ?? 0, 2) }}
                                        </td>
                                        <td class="py-6 px-4">
                                            @if($payment->receipt_path)
                                                <button @click="openReceipt('{{ asset('storage/' . $payment->receipt_path) }}', '{{ $member->name }}')" 
                                                        class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-900 text-[10px] font-bold uppercase tracking-widest group">
                                                    <svg class="w-4 h-4 group-hover:scale-125 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    View Receipt
                                                </button>
                                            @else
                                                <span class="text-[10px] text-red-300 italic font-bold">No Evidence</span>
                                            @endif
                                        </td>
                                        <td class="py-6 px-4 text-right">
                                            <form action="{{ route('accountant.verify', $payment) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-5 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-[10px] font-bold rounded-xl transition shadow-lg" onclick="return confirm('Confirm this specific receipt and update financial record?')">
                                                    Verify Payment
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-20 text-center text-emerald-200 italic font-bold uppercase tracking-widest">Clear queue! No pending payments.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $pendingPayments->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipt Preview Modal -->
        <div x-show="showReceipt" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-emerald-950/80 backdrop-blur-sm" @click="showReceipt = false"></div>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-emerald-100">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-emerald-950 font-outfit" x-text="'Receipt: ' + currentMember"></h3>
                                <p class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest mt-1">Uploaded Payment Evidence</p>
                            </div>
                            <button @click="showReceipt = false" class="p-2 hover:bg-emerald-50 rounded-xl transition text-emerald-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="bg-emerald-50 rounded-3xl p-4 overflow-hidden border border-emerald-100">
                            <template x-if="receiptUrl.toLowerCase().endsWith('.pdf')">
                                <iframe :src="receiptUrl" class="w-full h-[600px] rounded-2xl" frameborder="0"></iframe>
                            </template>
                            <template x-if="!receiptUrl.toLowerCase().endsWith('.pdf')">
                                <img :src="receiptUrl" class="w-full h-auto rounded-2xl shadow-inner mx-auto max-h-[70vh] object-contain">
                            </template>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button @click="showReceipt = false" class="px-8 py-3 bg-emerald-900 text-white font-bold rounded-2xl shadow-xl hover:bg-emerald-950 transition">
                                Close Preview
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
