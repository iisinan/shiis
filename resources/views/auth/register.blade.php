<x-guest-layout>
    <div class="flex flex-col lg:flex-row gap-12 items-start">
        
        <!-- Left Column: Registration Form -->
        <div class="w-full lg:w-3/5 space-y-8">
            <div class="text-left">
                <h2 class="text-4xl font-black text-emerald-950 font-outfit tracking-tight">Join the Fraternity</h2>
                <p class="text-emerald-700/60 mt-2 text-lg italic">"Stronger Together, Brighter Forever."</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-emerald-900 font-bold" />
                        <x-text-input id="name" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" class="text-emerald-900 font-bold" />
                        <x-text-input id="email" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone Number -->
                    <div>
                        <x-input-label for="phone_number" :value="__('Phone Number')" class="text-emerald-900 font-bold" />
                        <x-text-input id="phone_number" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="text" name="phone_number" :value="old('phone_number')" required placeholder="+234..." />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <!-- Amount Contributing -->
                    <div>
                        <x-input-label for="amount" :value="__('Contribution Amount (₦)')" class="text-emerald-900 font-bold" />
                        <x-text-input id="amount" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="number" name="amount" :value="old('amount', 5000)" min="5000" required placeholder="Minimum 5,000" />
                        <p class="mt-2 text-[10px] text-red-500 font-black uppercase tracking-widest">Note: Minimum contribution is ₦5,000</p>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>

                <!-- Receipt Upload -->
                <div class="bg-emerald-50/50 p-8 rounded-[2.5rem] border-2 border-dashed border-emerald-100" x-data="{ fileName: '' }">
                    <x-input-label for="receipt" :value="__('Payment Evidence (Image/PDF)')" class="text-emerald-900 font-bold mb-4" />
                    <div class="flex items-center justify-center w-full">
                        <label for="receipt" 
                            :class="fileName ? 'border-emerald-500 bg-emerald-100' : 'border-emerald-200 bg-white'"
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-[2rem] cursor-pointer hover:bg-emerald-50 transition duration-300">
                            
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <template x-if="!fileName">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-4 shadow-inner">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        </div>
                                        <p class="mb-1 text-sm text-emerald-900 font-bold">Upload your payment evidence</p>
                                        <p class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">JPG, PNG or PDF (MAX. 5MB)</p>
                                    </div>
                                </template>
                                
                                <template x-if="fileName">
                                    <div class="flex flex-col items-center">
                                        <div class="p-3 bg-emerald-600 rounded-full text-white mb-3 shadow-xl animate-bounce-slow">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-emerald-900 font-bold text-sm truncate max-w-xs" x-text="fileName"></p>
                                        <p class="text-emerald-600 text-[10px] uppercase font-bold mt-1 tracking-widest">Document Secured</p>
                                    </div>
                                </template>
                            </div>
                            
                            <input id="receipt" type="file" name="receipt" class="hidden" required @change="fileName = $event.target.files[0].name" />
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Create Password')" class="text-emerald-900 font-bold" />
                        <x-text-input id="password" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-emerald-900 font-bold" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between mt-10 gap-6">
                    <a class="text-sm text-emerald-700 font-black uppercase tracking-widest hover:text-emerald-950 transition" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="w-full sm:w-auto px-12 py-5 bg-emerald-900 hover:bg-emerald-950 shadow-2xl shadow-emerald-900/40 rounded-2xl transition-all transform hover:-translate-y-1 text-base font-bold">
                        {{ __('Complete Registration') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Right Column: Payment Instructions -->
        <div class="w-full lg:w-2/5 space-y-6">
            <div class="bg-emerald-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-emerald-900/30 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                </div>
                
                <h3 class="text-2xl font-bold font-outfit mb-6 flex items-center gap-3">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Payment Details
                </h3>

                <div class="space-y-8">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                        <p class="text-[10px] font-bold text-emerald-300 uppercase tracking-[0.2em] mb-4">Bank Account</p>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-emerald-100/60 block">Account Number</span>
                                <span class="text-2xl font-black font-outfit tracking-widest text-white">8039245585</span>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-100/60 block">Bank Name</span>
                                <span class="text-lg font-bold text-white">Moniepoint</span>
                            </div>
                            <div>
                                <span class="text-xs text-emerald-100/60 block">Account Name</span>
                                <span class="text-lg font-bold text-white">Yusuf Umar Adam</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-sm font-bold uppercase tracking-widest text-emerald-400">Important Information</h4>
                        <ul class="space-y-3 text-sm text-emerald-100/70 leading-relaxed italic">
                            <li class="flex gap-3">
                                <span class="text-emerald-400 font-bold">•</span>
                                <span>The system does not accept any payment less than <strong>₦5,000</strong>.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="text-emerald-400 font-bold">•</span>
                                <span>Ensure you take a screenshot or download your receipt after payment.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="text-emerald-400 font-bold">•</span>
                                <span>Verification by the finance team typically takes 2-4 hours.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-emerald-50 rounded-[2.5rem] border border-emerald-100 text-center">
                <p class="text-emerald-900/60 text-xs font-bold leading-relaxed">
                    Need assistance with your registration?<br>
                    Contact the committee on WhatsApp.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
