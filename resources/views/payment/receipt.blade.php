<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-6">
        
        <!-- Action Buttons -->
        <div class="w-full max-w-2xl flex justify-end mb-4 gap-4 print:hidden">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white text-emerald-900 text-sm font-bold rounded-lg shadow-sm border border-emerald-100 hover:bg-emerald-50 transition">
                Back to Dashboard
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-900 text-white text-sm font-bold rounded-lg shadow-sm hover:bg-emerald-950 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Receipt
            </button>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative print:shadow-none print:border-none print:w-full">
            
            <!-- Watermark -->
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
                <img src="{{ asset('images/logo.png') }}" class="w-96 h-96 object-contain grayscale">
            </div>

            <!-- Header -->
            <div class="bg-emerald-950 p-8 text-white relative flex justify-between items-center print:bg-white print:text-emerald-950 print:border-b-4 print:border-emerald-900">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="SHIIS Logo" class="w-16 h-16 object-contain bg-white p-1 rounded-lg">
                    <div>
                        <h1 class="text-2xl font-black tracking-widest uppercase">SHIIS Class of 2005</h1>
                        <p class="text-emerald-300 text-xs tracking-widest font-bold mt-1 print:text-emerald-700">Official Payment Receipt</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-widest text-emerald-400 font-bold mb-1 print:text-emerald-600">Receipt No.</p>
                    <p class="font-mono text-sm tracking-widest">{{ $payment->reference }}</p>
                </div>
            </div>

            <!-- Body -->
            <div class="p-10 relative z-10">
                <div class="flex justify-between items-start mb-12">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Issued To</p>
                        <p class="text-xl font-bold text-gray-900 uppercase">{{ $payment->user->name }}</p>
                        <p class="text-gray-600 mt-1">{{ $payment->user->email }}</p>
                        <p class="text-gray-500 text-sm mt-1">Graduation Year: {{ $payment->user->year_graduated ?? '2005' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Date Paid</p>
                        <p class="text-gray-900 font-bold">{{ $payment->created_at->format('F j, Y') }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ $payment->created_at->format('h:i A') }}</p>
                    </div>
                </div>

                <!-- Payment Details Table -->
                <div class="border border-gray-200 rounded-xl overflow-hidden mb-12">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Description</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-6 py-6">
                                    <p class="font-bold text-gray-900">Reunion Contribution / Dues</p>
                                    <p class="text-sm text-gray-500 mt-1">Mandatory contribution for SHIIS Class of '05</p>
                                </td>
                                <td class="px-6 py-6 text-right font-mono font-bold text-gray-900">
                                    ₦{{ number_format($payment->amount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-emerald-50">
                            <tr>
                                <td class="px-6 py-4 font-black text-emerald-900 uppercase tracking-widest text-right text-sm">Total Paid</td>
                                <td class="px-6 py-4 text-right font-mono font-black text-emerald-900 text-xl">
                                    ₦{{ number_format($payment->amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Signatures -->
                <div class="flex justify-between items-end mt-16 pt-8 border-t border-gray-100">
                    <div>
                        <div class="w-48 border-b-2 border-gray-800 mb-2"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Finance Administrator</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-full text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-black uppercase tracking-widest">Payment Verified</span>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-10 py-6 text-center border-t border-gray-100">
                <p class="text-xs text-gray-400">This is a computer-generated receipt and does not require a physical signature.</p>
                <p class="text-[10px] text-gray-300 mt-1 uppercase tracking-widest">SHIIS Class of 2005 Alumni Association</p>
            </div>
        </div>
    </div>
</x-guest-layout>
