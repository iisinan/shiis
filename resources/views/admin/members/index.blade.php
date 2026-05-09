<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Member Verification') }}
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-100">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-emerald-50">
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Colleague</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Contact Info</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Status</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Evidence</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @foreach($members as $member)
                                    <tr class="hover:bg-emerald-50/30 transition group">
                                        <td class="py-6 px-4">
                                            <div class="font-bold text-emerald-950">{{ $member->name }}</div>
                                        </td>
                                        <td class="py-6 px-4">
                                            <div class="text-sm text-emerald-800">{{ $member->email }}</div>
                                            <div class="text-[10px] text-emerald-600/50 font-bold mt-1">{{ $member->phone_number }}</div>
                                        </td>
                                        <td class="py-6 px-4">
                                            @if($member->is_paid)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-100 uppercase tracking-widest">
                                                    <div class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></div>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-full border border-amber-100 uppercase tracking-widest">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-6 px-4">
                                            @php $payment = $member->payments->last(); @endphp
                                            @if($payment && $payment->receipt_path)
                                                <button @click="openReceipt('{{ route('storage.proxy', ['folder' => 'receipts', 'filename' => basename($payment->receipt_path)]) }}', '{{ $member->name }}')" 
                                                        class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-900 text-[10px] font-bold uppercase tracking-widest group">
                                                    <svg class="w-4 h-4 group-hover:scale-125 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    View Receipt
                                                </button>
                                            @else
                                                <span class="text-[10px] text-emerald-200 italic font-bold">No Upload</span>
                                            @endif
                                        </td>
                                        <td class="py-6 px-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                @if(!$member->is_paid)
                                                    <form action="{{ route('admin.members.verify', $member) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="px-5 py-2 bg-emerald-900 hover:bg-emerald-950 text-white text-[10px] font-bold rounded-xl transition shadow-lg" onclick="return confirm('Verify contribution for {{ $member->name }}?')">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-emerald-200">
                                                        <svg class="w-6 h-6 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </span>
                                                @endif

                                                @unless($member->hasRole('Super Admin'))
                                                <button type="button" 
                                                        class="px-3 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 text-[10px] font-bold rounded-xl transition border border-emerald-100" 
                                                        onclick="triggerReset('{{ $member->id }}', '{{ $member->name }}')">
                                                    Reset PWD
                                                </button>

                                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 text-[10px] font-bold rounded-xl transition border border-red-100" onclick="return confirm('Are you sure you want to completely delete {{ $member->name }}? This action cannot be undone.')">
                                                        Delete
                                                    </button>
                                                </form>
                                                @endunless
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Reset Form -->
        <form id="reset-password-form" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="password" id="reset-password-value">
        </form>

        <script>
            function triggerReset(userId, userName) {
                const newPassword = prompt(`Enter a new password for ${userName} (min 8 characters):`, 'password123');
                if (newPassword && newPassword.length >= 8) {
                    const form = document.getElementById('reset-password-form');
                    form.action = `/admin/members/${userId}/reset-password`;
                    document.getElementById('reset-password-value').value = newPassword;
                    form.submit();
                } else if (newPassword) {
                    alert('Password must be at least 8 characters long.');
                }
            }
        </script>

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
