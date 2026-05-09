<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">Payment Approvals</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-emerald-50/40 via-white to-emerald-50/20 py-12"
         x-data="{
            showReceipt: false,
            receiptUrl: '',
            currentMember: '',
            currentAmount: '',
            openReceipt(url, name, amount) {
                this.receiptUrl = url;
                this.currentMember = name;
                this.currentAmount = amount;
                this.showReceipt = true;
            }
         }">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <!-- Pending -->
                <div class="relative bg-amber-50 border border-amber-200 rounded-3xl p-7 overflow-hidden">
                    <div class="absolute right-5 top-5 w-10 h-10 bg-amber-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-600">Pending</p>
                    <p class="text-4xl font-black font-outfit text-amber-700 mt-1">{{ $totalPendingCount }}</p>
                    <div class="flex items-center gap-2 mt-3">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse block"></span>
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Awaiting Review</span>
                    </div>
                </div>

                <!-- Verified Funds -->
                <div class="relative bg-emerald-900 rounded-3xl p-7 overflow-hidden shadow-xl shadow-emerald-900/20">
                    <div class="absolute right-5 top-5 w-10 h-10 bg-white/10 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-300">Total Verified</p>
                    <p class="text-3xl font-black font-outfit text-white mt-1">₦{{ number_format($totalVerifiedAmount, 2) }}</p>
                    <a href="{{ route('accountant.export') }}"
                       class="inline-flex items-center gap-2 mt-4 text-[10px] font-bold text-emerald-300 hover:text-white transition uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export CSV Report
                    </a>
                </div>

                <!-- Quick Guide -->
                <div class="relative bg-white border border-emerald-100 rounded-3xl p-7 shadow-sm">
                    <div class="absolute right-5 top-5 w-10 h-10 bg-emerald-50 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-600/50">How It Works</p>
                    <ol class="mt-3 space-y-1.5">
                        <li class="flex items-start gap-2 text-xs text-emerald-700">
                            <span class="w-4 h-4 bg-emerald-100 rounded-full text-[9px] font-black flex items-center justify-center shrink-0 mt-0.5">1</span>
                            View the payment receipt
                        </li>
                        <li class="flex items-start gap-2 text-xs text-emerald-700">
                            <span class="w-4 h-4 bg-emerald-100 rounded-full text-[9px] font-black flex items-center justify-center shrink-0 mt-0.5">2</span>
                            Confirm the amount matches
                        </li>
                        <li class="flex items-start gap-2 text-xs text-emerald-700">
                            <span class="w-4 h-4 bg-emerald-100 rounded-full text-[9px] font-black flex items-center justify-center shrink-0 mt-0.5">3</span>
                            Click Approve to unlock member
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Payment Queue -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-emerald-900/5 border border-emerald-100 overflow-hidden">
                <div class="px-8 pt-8 pb-4 border-b border-emerald-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-emerald-950 font-outfit">Payment Verification Queue</h3>
                        <p class="text-xs text-emerald-600/50 font-bold uppercase tracking-widest mt-1">Review and approve member contributions below</p>
                    </div>
                    @if($totalPendingCount > 0)
                        <span class="px-4 py-1.5 bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $totalPendingCount }} Pending
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            All Clear ✓
                        </span>
                    @endif
                </div>

                <div class="divide-y divide-emerald-50">
                    @forelse($pendingPayments as $payment)
                        @php $member = $payment->user; @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 px-8 py-6 hover:bg-emerald-50/30 transition group">

                            <!-- Avatar + Info -->
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-lg flex items-center justify-center shrink-0 shadow-inner">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-emerald-950 truncate">{{ $member->name }}</p>
                                    <p class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-tighter truncate">{{ $member->email }}</p>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="shrink-0">
                                <p class="text-[10px] font-bold text-emerald-600/40 uppercase tracking-widest">Amount</p>
                                <p class="text-xl font-black text-emerald-900 font-outfit">₦{{ number_format($payment->amount ?? 0, 2) }}</p>
                            </div>

                            <!-- Date -->
                            <div class="shrink-0">
                                <p class="text-[10px] font-bold text-emerald-600/40 uppercase tracking-widest">Submitted</p>
                                <p class="text-sm font-bold text-emerald-700">{{ $payment->created_at->format('d M Y') }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 shrink-0">
                                @if($payment->receipt_path)
                                    <button @click="openReceipt('{{ route('gallery.image', ['filename' => basename($payment->receipt_path)]) }}', '{{ addslashes($member->name) }}', '₦{{ number_format($payment->amount ?? 0, 2) }}')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-xl transition border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View Receipt
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-50 text-red-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-red-100">
                                        No Receipt
                                    </span>
                                @endif

                                <form action="{{ route('accountant.verify', $payment) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Approve payment of ₦{{ number_format($payment->amount ?? 0, 2) }} from {{ addslashes($member->name) }}?')"
                                            class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-900 hover:bg-emerald-950 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-emerald-900/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-32 text-center">
                            <div class="w-20 h-20 bg-emerald-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xl font-black text-emerald-900 font-outfit">Queue is clear!</p>
                            <p class="text-sm text-emerald-600/50 font-bold uppercase tracking-widest mt-2">All payments have been reviewed.</p>
                        </div>
                    @endforelse
                </div>

                @if($pendingPayments->hasPages())
                    <div class="px-8 py-6 border-t border-emerald-50">
                        {{ $pendingPayments->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- Receipt Preview Modal -->
        <div x-show="showReceipt"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-emerald-950/80 backdrop-blur-sm"
             @click.self="showReceipt = false"
             @keydown.escape.window="showReceipt = false">

            <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col overflow-hidden border border-emerald-100">

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-8 py-6 border-b border-emerald-50">
                    <div>
                        <h3 class="text-xl font-bold text-emerald-950 font-outfit" x-text="currentMember + ' — Payment Receipt'"></h3>
                        <p class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest mt-1" x-text="'Amount: ' + currentAmount"></p>
                    </div>
                    <button @click="showReceipt = false"
                            class="w-10 h-10 rounded-2xl bg-emerald-50 hover:bg-emerald-100 flex items-center justify-center transition text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Receipt Content -->
                <div class="flex-1 overflow-auto p-6 bg-emerald-50/50">
                    <template x-if="receiptUrl.toLowerCase().endsWith('.pdf')">
                        <iframe :src="receiptUrl" class="w-full h-[60vh] rounded-2xl border border-emerald-100" frameborder="0"></iframe>
                    </template>
                    <template x-if="!receiptUrl.toLowerCase().endsWith('.pdf')">
                        <img :src="receiptUrl" class="max-h-[60vh] mx-auto rounded-2xl shadow-inner object-contain">
                    </template>
                </div>

                <!-- Modal Footer -->
                <div class="px-8 py-5 border-t border-emerald-50 flex justify-end">
                    <button @click="showReceipt = false"
                            class="px-8 py-3 bg-emerald-900 text-white font-bold rounded-2xl shadow-lg hover:bg-emerald-950 transition text-sm">
                        Close Preview
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
