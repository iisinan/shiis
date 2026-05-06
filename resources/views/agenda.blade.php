<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Reunion Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center">
                <span class="inline-block px-4 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100 uppercase tracking-widest mb-4">Official Schedule</span>
                <h3 class="text-4xl font-extrabold text-emerald-950 font-outfit">The Grand Reunion '05</h3>
                <p class="mt-4 text-emerald-700/60 font-medium max-w-2xl mx-auto italic">"A carefully curated journey of nostalgia, networking, and celebration."</p>
            </div>

            @if($agendas->isEmpty())
                <div class="text-center py-32 bg-white rounded-[2.5rem] border border-dashed border-emerald-100 shadow-xl shadow-emerald-900/5">
                    <svg class="w-20 h-20 text-emerald-100 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-emerald-800/40 font-bold text-xl uppercase tracking-widest">Schedule is being finalized.</p>
                </div>
            @else
                <div class="relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-emerald-100 rounded-full hidden md:block"></div>
                    
                    <div class="space-y-16">
                        @foreach($agendas as $index => $item)
                            <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 md:gap-0">
                                <!-- Dot -->
                                <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-emerald-900 rounded-full border-4 border-white shadow-lg z-10 hidden md:block"></div>

                                <!-- Left/Right Content -->
                                <div class="w-full md:w-[42%] {{ $index % 2 == 0 ? 'md:text-right' : 'md:order-last' }}">
                                    <div class="bg-white p-8 rounded-[2rem] border border-emerald-100 shadow-xl shadow-emerald-900/5 hover:border-emerald-300 transition duration-500 transform hover:-translate-y-2">
                                        <span class="text-emerald-600 font-black text-xs uppercase tracking-[0.2em] mb-2 block">{{ $item->time }}</span>
                                        <h4 class="text-2xl font-bold text-emerald-950 font-outfit mb-3">{{ $item->title }}</h4>
                                        <p class="text-emerald-700/60 text-sm leading-relaxed">{{ $item->description }}</p>
                                        @if($item->location)
                                            <div class="mt-4 flex items-center gap-2 {{ $index % 2 == 0 ? 'md:justify-end' : '' }}">
                                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">{{ $item->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Empty Space -->
                                <div class="hidden md:block w-[42%]"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
