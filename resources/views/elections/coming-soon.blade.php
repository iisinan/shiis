<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-white p-6 overflow-hidden relative">
        <!-- Abstract Background Elements -->
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>

        <div class="max-w-3xl w-full text-center space-y-12 relative z-10">
            <!-- Icon & Heading -->
            <div class="space-y-6">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-emerald-500 blur-3xl opacity-20 animate-pulse"></div>
                    <div class="relative bg-emerald-900 w-32 h-32 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-2xl border-4 border-emerald-50">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <h2 class="text-5xl md:text-6xl font-black text-emerald-950 font-outfit tracking-tight">Election Polls Closed</h2>
                    <p class="text-lg text-emerald-800/60 font-medium">The ballot box is currently sealed. Ready for the big day?</p>
                </div>
            </div>

            <!-- Live Countdown Grid -->
            <div class="bg-emerald-900 rounded-[3.5rem] p-12 text-white shadow-2xl shadow-emerald-900/30 relative overflow-hidden" 
                 x-data="comingSoonTimer('{{ $rawDate }}')">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                </div>
                
                <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10">
                        <span class="text-4xl md:text-5xl font-black font-outfit block mb-1" x-text="days">00</span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400">Days</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10">
                        <span class="text-4xl md:text-5xl font-black font-outfit block mb-1" x-text="hours">00</span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400">Hours</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10">
                        <span class="text-4xl md:text-5xl font-black font-outfit block mb-1" x-text="minutes">00</span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400">Minutes</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10">
                        <span class="text-4xl md:text-5xl font-black font-outfit block mb-1" x-text="seconds">00</span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400">Seconds</span>
                    </div>
                </div>
                
                <div class="mt-12 relative z-10 border-t border-white/10 pt-8">
                    <p class="text-emerald-200/60 text-sm italic">"The ballot is stronger than the bullet."</p>
                    <div class="mt-4 inline-flex items-center gap-3 px-6 py-2 bg-white/5 rounded-full border border-white/10">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-100">Election Day: {{ $activeDate }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 text-sm font-bold text-emerald-900 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-2 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="underline decoration-dashed underline-offset-8">Return to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function comingSoonTimer(targetStr) {
            return {
                days: '00', hours: '00', minutes: '00', seconds: '00',
                init() {
                    const targetDate = new Date('{{ $rawDate }}'.replace(/-/g, '/')).getTime();
                    const update = () => {
                        const now = new Date().getTime();
                        const distance = targetDate - now;
                        if(distance < 0) {
                            window.location.reload();
                            return;
                        }
                        this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                        this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                        this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }
    </script>
</x-app-layout>
