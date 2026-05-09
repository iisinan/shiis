<x-guest-layout>
    <div class="min-h-screen py-12 px-4 sm:px-6 flex items-center justify-center bg-emerald-50/30">
        <div class="w-full max-w-2xl">
            
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-900 text-white mb-6 shadow-xl shadow-emerald-900/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h2 class="text-4xl font-black text-emerald-950 font-outfit tracking-tight">Join the Brotherhood</h2>
                <p class="text-emerald-700 mt-3 text-lg font-medium">SHIIS Class of 2005 Reunion Portal</p>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-emerald-900/10 border border-emerald-100/50 overflow-hidden">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Section: Payment Instructions -->
                    <div class="bg-emerald-900 p-8 text-white">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-emerald-800/50 rounded-xl">
                                <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold font-outfit mb-1">Step 1: Make Your Contribution</h3>
                                <p class="text-emerald-200/80 text-sm leading-relaxed mb-4">Please make a minimum contribution of ₦5,000 to the official reunion account below before filling out this form. You will need to upload your receipt.</p>
                                
                                <div class="bg-black/20 rounded-2xl p-5 border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] text-emerald-300 uppercase tracking-widest font-bold mb-1">Account Number</p>
                                        <p class="text-3xl font-mono font-black tracking-widest text-white select-all">8039245585</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-[10px] text-emerald-300 uppercase tracking-widest font-bold mb-1">Bank Details</p>
                                        <p class="font-bold text-white text-sm">Moniepoint</p>
                                        <p class="text-xs text-white/70">Yusuf U. Adam</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 sm:p-10 space-y-10">
                        <!-- Section: Personal Details -->
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">2</div>
                                <h3 class="text-xl font-bold text-emerald-950 font-outfit">Personal Details</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="space-y-2 col-span-1 sm:col-span-2">
                                    <label for="name" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">Full Name</label>
                                    <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                                        class="block w-full bg-emerald-50/50 border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 transition-colors"
                                        placeholder="Enter your full name">
                                    <x-input-error :messages="$errors->get('name')" />
                                </div>

                                <!-- Email Address -->
                                <div class="space-y-2">
                                    <label for="email" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">Email Address</label>
                                    <input id="email" type="email" name="email" :value="old('email')" required 
                                        class="block w-full bg-emerald-50/50 border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 transition-colors"
                                        placeholder="email@example.com">
                                    <x-input-error :messages="$errors->get('email')" />
                                </div>

                                <!-- Phone Number -->
                                <div class="space-y-2">
                                    <label for="phone_number" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">WhatsApp Number</label>
                                    <input id="phone_number" type="text" name="phone_number" :value="old('phone_number')" required 
                                        class="block w-full bg-emerald-50/50 border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 transition-colors"
                                        placeholder="e.g. 080...">
                                    <x-input-error :messages="$errors->get('phone_number')" />
                                </div>
                            </div>
                        </div>

                        <hr class="border-emerald-50">

                        <!-- Section: Verification & Security -->
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">3</div>
                                <h3 class="text-xl font-bold text-emerald-950 font-outfit">Verification & Security</h3>
                            </div>

                            <div class="space-y-8">
                                <!-- Contribution Amount & Receipt Row -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                                    <div class="space-y-2">
                                        <label for="amount" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">Amount Paid (₦)</label>
                                        <input id="amount" type="number" name="amount" :value="old('amount', 5000)" min="5000" required 
                                            class="block w-full bg-emerald-50/50 border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 font-bold transition-colors">
                                        <x-input-error :messages="$errors->get('amount')" />
                                    </div>

                                    <div x-data="{ fileName: '' }" class="space-y-2">
                                        <label class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1 block">Payment Receipt</label>
                                        <label for="receipt" 
                                            :class="fileName ? 'bg-emerald-900 text-white border-emerald-900' : 'bg-white text-emerald-700 border-emerald-200 hover:bg-emerald-50'"
                                            class="flex items-center justify-center w-full px-4 py-3 rounded-xl border border-dashed cursor-pointer transition-colors h-[50px]">
                                            <span class="font-bold text-sm truncate px-2" x-text="fileName ? fileName : 'Choose File (JPG/PNG/PDF)'"></span>
                                            <input id="receipt" type="file" name="receipt" class="hidden" required @change="fileName = $event.target.files[0].name" />
                                        </label>
                                        <x-input-error :messages="$errors->get('receipt')" />
                                    </div>
                                </div>

                                <!-- Password Row -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-emerald-50/30 p-6 rounded-2xl border border-emerald-50">
                                    <div class="space-y-2">
                                        <label for="password" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">Create Password</label>
                                        <input id="password" type="password" name="password" required 
                                            class="block w-full bg-white border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 transition-colors"
                                            placeholder="Min. 8 characters">
                                        <x-input-error :messages="$errors->get('password')" />
                                    </div>

                                    <div class="space-y-2">
                                        <label for="password_confirmation" class="text-xs font-bold text-emerald-900 uppercase tracking-wider ml-1">Confirm Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                                            class="block w-full bg-white border border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-4 py-3 text-emerald-950 transition-colors"
                                            placeholder="Repeat your password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full py-5 bg-emerald-900 text-white font-bold rounded-2xl shadow-xl shadow-emerald-900/20 hover:bg-emerald-950 hover:-translate-y-0.5 transition-all active:translate-y-0 text-lg tracking-wide">
                                Submit Registration
                            </button>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-900 transition-colors">
                                    Already have an account? Login here
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-10 text-center text-emerald-900/40 text-xs font-bold uppercase tracking-widest pb-8">
                &copy; {{ date('Y') }} SHIIS '05 Reunion Committee
            </div>
        </div>
    </div>
</x-guest-layout>
