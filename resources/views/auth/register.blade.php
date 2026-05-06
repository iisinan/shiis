<x-guest-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h2 class="text-5xl font-black text-emerald-950 font-outfit tracking-tight">Join the Brotherhood</h2>
            <p class="text-emerald-700/60 mt-4 text-lg font-medium italic">SHIIS Class of 2005 Reunion Portal</p>
            <div class="mt-6 flex justify-center gap-2">
                <div class="w-12 h-1.5 bg-emerald-900 rounded-full"></div>
                <div class="w-4 h-1.5 bg-emerald-200 rounded-full"></div>
                <div class="w-4 h-1.5 bg-emerald-100 rounded-full"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-10">
            @csrf

            <!-- Section 1: Member Profile -->
            <div class="bg-white rounded-[3rem] p-10 shadow-2xl shadow-emerald-950/5 border border-emerald-50">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-emerald-50">
                    <div class="w-12 h-12 bg-emerald-900 rounded-2xl flex items-center justify-center text-white shadow-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-emerald-950 font-outfit">Member Profile</h3>
                        <p class="text-xs text-emerald-600 font-bold uppercase tracking-widest mt-1">Personal & Contact Information</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Full Name')" class="text-emerald-900 font-bold ml-2" />
                        <x-text-input id="name" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-2xl px-6 py-4 shadow-sm transition" type="text" name="name" :value="old('name')" required autofocus placeholder="Enter your full name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" class="text-emerald-900 font-bold ml-2" />
                        <x-text-input id="email" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-2xl px-6 py-4 shadow-sm transition" type="email" name="email" :value="old('email')" required placeholder="email@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <x-input-label for="phone_number" :value="__('WhatsApp Number')" class="text-emerald-900 font-bold ml-2" />
                        <x-text-input id="phone_number" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-2xl px-6 py-4 shadow-sm transition" type="text" name="phone_number" :value="old('phone_number')" required placeholder="e.g. 080..." />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <!-- Contribution Amount -->
                    <div class="space-y-2">
                        <x-input-label for="amount" :value="__('Contribution Amount (₦)')" class="text-emerald-900 font-bold ml-2" />
                        <x-text-input id="amount" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-2xl px-6 py-4 shadow-sm transition font-bold text-emerald-950" type="number" name="amount" :value="old('amount', 5000)" min="5000" required />
                        <div class="flex items-center gap-2 mt-2 ml-2">
                            <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest">Minimum contribution: ₦5,000</p>
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Payment & Security -->
            <div class="bg-white rounded-[3rem] p-10 shadow-2xl shadow-emerald-950/5 border border-emerald-50 overflow-hidden relative">
                <!-- Watermark Logo -->
                <div class="absolute top-0 right-0 p-10 opacity-5 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                </div>

                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-emerald-50">
                    <div class="w-12 h-12 bg-emerald-900 rounded-2xl flex items-center justify-center text-white shadow-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-emerald-950 font-outfit">Payment Verification</h3>
                        <p class="text-xs text-emerald-600 font-bold uppercase tracking-widest mt-1">Settlement & Account Security</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Instructions -->
                    <div class="space-y-6">
                        <div class="bg-emerald-900 rounded-[2rem] p-8 text-white shadow-xl">
                            <p class="text-[10px] font-bold text-emerald-300 uppercase tracking-widest mb-4">Official Payment Account</p>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-[10px] text-emerald-200/60 uppercase block">Account Number</span>
                                    <span class="text-3xl font-black font-outfit tracking-tighter">8039245585</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[10px] text-emerald-200/60 uppercase block">Bank Name</span>
                                        <span class="font-bold">Moniepoint</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-emerald-200/60 uppercase block">Account Name</span>
                                        <span class="font-bold">Yusuf U. Adam</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 italic text-xs text-emerald-800 leading-relaxed">
                            "Please upload your payment receipt below. Our finance team will verify the transaction and activate your full membership within 2-4 hours."
                        </div>
                    </div>

                    <!-- Upload & Password -->
                    <div class="space-y-8">
                        <!-- Receipt Upload -->
                        <div x-data="{ fileName: '' }" class="relative">
                            <x-input-label for="receipt" :value="__('Payment Evidence')" class="text-emerald-900 font-bold mb-2 ml-2" />
                            <label for="receipt" 
                                :class="fileName ? 'border-emerald-500 bg-emerald-50' : 'border-emerald-100 bg-emerald-50/30'"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-2xl cursor-pointer hover:bg-emerald-50 transition duration-300 group">
                                <div class="flex flex-col items-center text-center px-4">
                                    <template x-if="!fileName">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </div>
                                            <p class="text-sm text-emerald-900 font-bold">Select Receipt (JPG/PNG/PDF)</p>
                                        </div>
                                    </template>
                                    <template x-if="fileName">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg animate-pulse">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="text-xs text-emerald-900 font-bold truncate max-w-[150px]" x-text="fileName"></p>
                                        </div>
                                    </template>
                                </div>
                                <input id="receipt" type="file" name="receipt" class="hidden" required @change="fileName = $event.target.files[0].name" />
                            </label>
                            <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                        </div>

                        <!-- Passwords -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <x-input-label for="password" :value="__('Password')" class="text-emerald-900 font-bold ml-2 text-xs uppercase" />
                                <x-text-input id="password" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-xl px-4 py-3" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>
                            <div class="space-y-1">
                                <x-input-label for="password_confirmation" :value="__('Confirm')" class="text-emerald-900 font-bold ml-2 text-xs uppercase" />
                                <x-text-input id="password_confirmation" class="block w-full bg-emerald-50/30 border-emerald-100 focus:bg-white focus:ring-emerald-500 rounded-xl px-4 py-3" type="password" name="password_confirmation" required autocomplete="new-password" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="flex flex-col items-center gap-8 pt-4">
                <x-primary-button class="w-full sm:w-auto px-20 py-6 bg-emerald-900 hover:bg-emerald-950 shadow-2xl shadow-emerald-900/40 rounded-3xl transition-all transform hover:-translate-y-1 text-lg font-bold">
                    {{ __('Complete My Registration') }}
                </x-primary-button>
                
                <a class="text-xs text-emerald-700 font-black uppercase tracking-widest hover:text-emerald-950 transition flex items-center gap-2 group" href="{{ route('login') }}">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path></svg>
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>

        <div class="mt-20 text-center text-emerald-900/40 text-xs font-bold uppercase tracking-widest pb-10">
            &copy; {{ date('Y') }} SHIIS '05 Reunion Committee. All Rights Reserved.
        </div>
    </div>
</x-guest-layout>
