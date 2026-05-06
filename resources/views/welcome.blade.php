<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHIIS '05 Reunion | 21-Year Anniversary</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary-green: #064e3b; /* emerald-900 */
            --accent-green: #059669; /* emerald-600 */
            --light-green: #ecfdf5; /* emerald-50 */
        }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .hero-bg {
            background: radial-gradient(circle at top right, rgba(6, 78, 59, 0.03), transparent),
                        radial-gradient(circle at bottom left, rgba(5, 150, 105, 0.03), transparent);
            background-color: #ffffff;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(6, 78, 59, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-green-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
        }
        /* Override dark mode to stay green/white */
        .dark body { background-color: #ffffff !important; color: #064e3b !important; }
        .dark .bg-gray-900, .dark .bg-gray-950 { background-color: #064e3b !important; }
        .dark .text-white { color: #ffffff !important; }
    </style>
</head>
<body class="antialiased text-green-900 font-inter bg-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-card transition-all duration-300 border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="SHIIS Logo" class="w-12 h-12 rounded-full object-cover shadow-md border-2 border-emerald-600">
                    <span class="font-outfit font-bold text-xl tracking-tight text-emerald-900">SHIIS '05</span>
                </div>
                <div class="hidden md:flex space-x-8 items-center text-sm font-semibold">
                    <a href="{{ route('agenda') }}" class="text-emerald-800 hover:text-emerald-600 transition">Agenda</a>
                    <a href="{{ route('gallery.index') }}" class="text-emerald-800 hover:text-emerald-600 transition">Gallery</a>
                    <a href="#about" class="text-emerald-800 hover:text-emerald-600 transition">About</a>
                    <a href="#gallery" class="text-emerald-800 hover:text-emerald-600 transition">Memories</a>
                    <a href="#executives" class="text-emerald-800 hover:text-emerald-600 transition">Executives</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 rounded-full bg-emerald-700 text-white hover:bg-emerald-800 transition shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-emerald-800 hover:text-emerald-600 transition">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 rounded-full bg-emerald-700 text-white hover:bg-emerald-800 transition shadow-lg">Join Reunion</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Reunion Logo" class="w-40 h-40 mx-auto mb-8 drop-shadow-xl animate-bounce-slow">
            <span class="inline-block py-1 px-4 rounded-full bg-emerald-50 text-emerald-700 text-sm font-bold tracking-wider mb-6 border border-emerald-100">
                21-YEAR ANNIVERSARY REUNION
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 font-outfit text-emerald-950">
                Class of 2005 <br class="hidden md:block" />
                <span class="gradient-text">Stronger Together, Brighter Forever</span>
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-emerald-800/80 mx-auto mb-10">
                School for Higher Islamic Studies, Zaria Road. Join us to celebrate two decades of brotherhood, leadership, and cherished memories.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-4 text-base font-bold rounded-full text-white bg-emerald-700 hover:bg-emerald-800 shadow-xl transition-all transform hover:-translate-y-1">
                    Register Now
                </a>
                <a href="#gallery" class="inline-flex items-center justify-center px-10 py-4 text-base font-bold rounded-full text-emerald-900 bg-white border-2 border-emerald-100 hover:bg-emerald-50 shadow-lg transition-all transform hover:-translate-y-1">
                    View Memories
                </a>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="py-12 bg-white border-y border-emerald-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-emerald-50 rounded-3xl p-10 shadow-inner border border-emerald-100" x-data="countdownTimer()">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <span class="text-4xl md:text-6xl font-bold text-emerald-900 font-outfit" x-text="days">00</span>
                        <p class="text-emerald-600/60 text-sm mt-1 uppercase tracking-widest font-bold">Days</p>
                    </div>
                    <div>
                        <span class="text-4xl md:text-6xl font-bold text-emerald-900 font-outfit" x-text="hours">00</span>
                        <p class="text-emerald-600/60 text-sm mt-1 uppercase tracking-widest font-bold">Hours</p>
                    </div>
                    <div>
                        <span class="text-4xl md:text-6xl font-bold text-emerald-900 font-outfit" x-text="minutes">00</span>
                        <p class="text-emerald-600/60 text-sm mt-1 uppercase tracking-widest font-bold">Minutes</p>
                    </div>
                    <div>
                        <span class="text-4xl md:text-6xl font-bold text-emerald-600 font-outfit" x-text="seconds">00</span>
                        <p class="text-emerald-600/60 text-sm mt-1 uppercase tracking-widest font-bold">Seconds</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-24 bg-white" x-data="{ 
        showSlideshow: false, 
        currentIdx: 0,
        images: [
            @foreach($images as $img)
                { url: '{{ Storage::url($img->image_path) }}', title: '{{ $img->title }}' },
            @endforeach
        ],
        next() { this.currentIdx = (this.currentIdx + 1) % this.images.length },
        prev() { this.currentIdx = (this.currentIdx - 1 + this.images.length) % this.images.length }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold font-outfit mb-4 text-emerald-950">School Memories</h2>
                <p class="text-emerald-700/60 max-w-xl mx-auto">A visual journey through the moments that shaped our brotherhood at SHIIS.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                @foreach($images->take(5) as $index => $img)
                    <div class="group relative overflow-hidden rounded-[2.5rem] aspect-square bg-emerald-50 shadow-lg border border-emerald-100 cursor-pointer"
                         @click="currentIdx = {{ $index }}; showSlideshow = true">
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $img->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-emerald-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-8">
                            <p class="text-white text-sm font-bold tracking-wide">{{ $img->title }}</p>
                        </div>
                    </div>
                @endforeach

                @if($images->count() > 5)
                    <div class="group relative overflow-hidden rounded-[2.5rem] aspect-square bg-emerald-900 shadow-2xl flex flex-col items-center justify-center text-center p-8 cursor-pointer transform hover:-translate-y-2 transition duration-500"
                         @click="currentIdx = 5; showSlideshow = true">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-4 backdrop-blur-md border border-white/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-xl font-outfit">View All Memories</h4>
                        <p class="text-emerald-300 text-xs mt-2 uppercase tracking-widest font-bold">+{{ $images->count() - 5 }} More Stories</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Slideshow Modal -->
        <div x-show="showSlideshow" 
             class="fixed inset-0 z-[100] flex items-center justify-center bg-emerald-950/95 backdrop-blur-xl"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             @keydown.escape.window="showSlideshow = false"
             style="display: none;">
            
            <!-- Close Button -->
            <button @click="showSlideshow = false" class="absolute top-10 right-10 text-white/50 hover:text-white transition z-[110]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Navigation -->
            <button @click="prev()" class="absolute left-10 p-4 bg-white/5 hover:bg-white/10 text-white rounded-full transition z-[110]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="next()" class="absolute right-10 p-4 bg-white/5 hover:bg-white/10 text-white rounded-full transition z-[110]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Slide Content -->
            <div class="max-w-5xl w-full px-4 text-center">
                <div class="relative group">
                    <img :src="images[currentIdx].url" :alt="images[currentIdx].title" 
                         class="max-h-[70vh] mx-auto rounded-[3rem] shadow-2xl border-4 border-white/10 object-contain">
                    <div class="mt-8">
                        <h3 class="text-3xl font-bold text-white font-outfit" x-text="images[currentIdx].title"></h3>
                        <p class="text-emerald-400 font-bold uppercase tracking-[0.3em] text-xs mt-4" x-text="(currentIdx + 1) + ' / ' + images.length"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Executives Section -->
    <section id="executives" class="py-24 bg-emerald-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4 font-outfit text-emerald-950">Leadership Formations</h2>
            <p class="text-emerald-700/60 max-w-2xl mx-auto mb-16 text-lg">The Class of 2005 will elect its dedicated executive committee to lead our community.</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $positions = [
                        'Chairman', 'Vice Chairman', 'Secretary', 'Assistant Secretary', 
                        'Treasurer', 'Financial Secretary', 'PRO', 'Welfare Officer', 'Social/Event Coordinator'
                    ];
                @endphp
                @foreach($positions as $pos)
                <div class="bg-white rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 border border-emerald-100 shadow-sm hover:shadow-xl">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-700 rounded-2xl mx-auto flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-emerald-900 text-lg">{{ $pos }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left">
                <div class="flex items-center gap-4 mb-8 md:mb-0">
                    <img src="{{ asset('images/logo.png') }}" alt="SHIIS Logo" class="w-16 h-16 rounded-full border-2 border-white/30 p-1 bg-white">
                    <div>
                        <span class="font-outfit font-bold text-2xl tracking-tight block">SHIIS '05 Reunion</span>
                        <span class="text-emerald-300 text-xs uppercase tracking-widest font-bold">Stronger Together, Brighter Forever</span>
                    </div>
                </div>
                <div class="text-emerald-100/60 text-sm">
                    &copy; 2026 SHIIS Class of 2005 Reunion Committee.<br>
                    Designed with pride for the School for Higher Islamic Studies.
                </div>
            </div>
        </div>
    </footer>

    <script>
        function countdownTimer() {
            return {
                days: '00', hours: '00', minutes: '00', seconds: '00',
                init() {
                    const targetDate = new Date("May 31, 2026 10:00:00").getTime();
                    setInterval(() => {
                        const now = new Date().getTime();
                        const distance = targetDate - now;
                        if(distance < 0) return;
                        this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                        this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                        this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                    }, 1000);
                }
            }
        }
    </script>
</body>
</html>
