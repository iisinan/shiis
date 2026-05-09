<x-guest-layout>
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Main Container with subtle glass effect background -->
        <div class="relative bg-white/80 backdrop-blur-xl rounded-[3.5rem] shadow-2xl shadow-emerald-900/10 border border-emerald-100/50 overflow-hidden">
            
            <!-- Top Accent Bar -->
            <div class="h-2 bg-gradient-to-r from-emerald-400 via-emerald-600 to-emerald-900"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12">
                <!-- Left Sidebar: Info & Branding -->
                <div class="lg:col-span-4 bg-emerald-900 p-8 lg:p-12 text-white relative overflow-hidden">
                    <!-- Abstract Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
                        </svg>
                    </div>

                    <div class="relative z-10 space-y-10">
                        <div>
                            <h2 class="text-4xl font-black font-outfit leading-tight">Join the<br>Brotherhood</h2>
                            <p class="text-emerald-200/60 mt-4 font-medium italic">SHIIS Class of 2005 Reunion</p>
                        </div>

                        <div class="space-y-8">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-800 rounded-xl flex items-center justify-center border border-emerald-700">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">Verified Network</h4>
                                    <p class="text-xs text-emerald-300/70 mt-1">Connect with 100+ verified alumni members.</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-800 rounded-xl flex items-center justify-center border border-emerald-700">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">Active Voting</h4>
                                    <p class="text-xs text-emerald-300/70 mt-1">Participate in executive elections & polls.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Callout -->
                        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10 mt-12">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-400 block mb-3">Reunion Contribution</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black font-outfit">₦5,000</span>
                                <span class="text-xs text-emerald-200/50">minimum</span>
                            </div>
                            <div class="mt-6 pt-6 border-t border-white/10">
                                <p class="text-[10px] text-emerald-200/80 leading-relaxed uppercase tracking-wider font-bold">Pay to Account Below & Upload Evidence</p>
                                <div class="mt-3 space-y-2">
                                    <div class="flex justify-between items-center bg-black/20 p-3 rounded-xl border border-white/5">
                                        <span class="text-xs font-mono font-bold tracking-widest text-emerald-300 select-all">8039245585</span>
                                        <span class="text-[8px] font-bold text-white/40 uppercase">Moniepoint</span>
                                    </div>
                                    <p class="text-[10px] text-center font-bold text-emerald-400 uppercase tracking-widest">Yusuf U. Adam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Registration Form -->
                <div class="lg:col-span-8 p-8 lg:p-16">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-12">
                        @csrf

                        <!-- Profile Header -->
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-1.5 bg-emerald-900 rounded-full"></div>
                            <h3 class="text-xl font-bold text-emerald-950 font-outfit uppercase tracking-wider">Member Details</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">Full Name</label>
                                <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                                    class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-medium placeholder:text-emerald-900/20"
                                    placeholder="Enter your full name">
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <!-- Email Address -->
                            <div class="space-y-2">
                                <label for="email" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">Email Address</label>
                                <input id="email" type="email" name="email" :value="old('email')" required 
                                    class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-medium placeholder:text-emerald-900/20"
                                    placeholder="email@example.com">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>

                            <!-- Phone Number -->
                            <div class="space-y-2">
                                <label for="phone_number" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">WhatsApp Number</label>
                                <input id="phone_number" type="text" name="phone_number" :value="old('phone_number')" required 
                                    class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-medium placeholder:text-emerald-900/20"
                                    placeholder="e.g. 080...">
                                <x-input-error :messages="$errors->get('phone_number')" />
                            </div>

                            <!-- Contribution Amount -->
                            <div class="space-y-2">
                                <label for="amount" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">Contribution (₦)</label>
                                <input id="amount" type="number" name="amount" :value="old('amount', 5000)" min="5000" required 
                                    class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-black"
                                    placeholder="5000">
                                <x-input-error :messages="$errors->get('amount')" />
                            </div>
                        </div>

                        <!-- Security & Verification -->
                        <div class="space-y-12 pt-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-1.5 bg-emerald-900 rounded-full"></div>
                                <h3 class="text-xl font-bold text-emerald-950 font-outfit uppercase tracking-wider">Verification & Security</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                                <!-- Receipt Upload -->
                                <div x-data="{ fileName: '' }" class="relative col-span-full">
                                    <label class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1 mb-3 block">Upload Payment Evidence</label>
                                    <label for="receipt" 
                                        :class="fileName ? 'bg-emerald-900 text-white shadow-xl scale-[1.01]' : 'bg-emerald-50 text-emerald-900/40 hover:bg-emerald-100'"
                                        class="flex items-center justify-between w-full px-6 py-8 rounded-[2rem] border-2 border-dashed border-emerald-200 cursor-pointer transition-all group overflow-hidden">
                                        <div class="flex items-center gap-4">
                                            <div :class="fileName ? 'bg-white/20' : 'bg-white'" class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm">
                                                <svg x-show="!fileName" class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                <svg x-show="fileName" class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <div class="text-left">
                                                <p class="font-bold text-sm" x-text="fileName ? 'Evidence Selected' : 'Select Receipt (JPG/PNG/PDF)'"></p>
                                                <p class="text-[10px] opacity-60 uppercase tracking-widest font-black" x-text="fileName ? fileName : 'Proof of Payment'"></p>
                                            </div>
                                        </div>
                                        <div class="hidden sm:block">
                                            <span class="px-4 py-2 bg-white/10 rounded-xl text-[8px] font-black uppercase tracking-widest border border-white/10">Browse Files</span>
                                        </div>
                                        <input id="receipt" type="file" name="receipt" class="hidden" required @change="fileName = $event.target.files[0].name" />
                                    </label>
                                    <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="space-y-2">
                                    <label for="password" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">Create Password</label>
                                    <input id="password" type="password" name="password" required 
                                        class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-medium"
                                        placeholder="Min. 8 characters">
                                    <x-input-error :messages="$errors->get('password')" />
                                </div>

                                <!-- Password Confirmation -->
                                <div class="space-y-2">
                                    <label for="password_confirmation" class="text-[10px] font-black text-emerald-900/50 uppercase tracking-widest ml-1">Confirm Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                                        class="block w-full bg-emerald-50/50 border-0 border-b-2 border-emerald-100 focus:border-emerald-900 focus:ring-0 transition-all px-0 py-3 text-emerald-950 font-medium"
                                        placeholder="Repeat your password">
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-8 pt-8 border-t border-emerald-50">
                            <a href="{{ route('login') }}" class="text-[10px] font-black text-emerald-900/40 uppercase tracking-widest hover:text-emerald-900 transition flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path></svg>
                                Already a member? Login
                            </a>

                            <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-emerald-900 text-white font-bold rounded-3xl shadow-2xl shadow-emerald-900/20 hover:bg-emerald-950 hover:-translate-y-1 transition transform active:scale-95">
                                Join the Brotherhood
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center text-emerald-900/20 text-[10px] font-black uppercase tracking-[0.3em]">
            &copy; {{ date('Y') }} SHIIS '05 Reunion Committee. All Rights Reserved.
        </div>
    </div>
</x-guest-layout>
