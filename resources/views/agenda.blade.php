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
                <div class="max-w-3xl mx-auto">
                    <div class="space-y-8">
                        @foreach($agendas as $index => $item)
                            <div class="relative pl-12 md:pl-20 group">
                                <!-- Vertical Line Fragment -->
                                @if(!$loop->last)
                                    <div class="absolute left-[23px] md:left-[31px] top-10 bottom-0 w-0.5 bg-emerald-100 group-hover:bg-emerald-300 transition-colors duration-500"></div>
                                @endif

                                <!-- Order Circle -->
                                <div class="absolute left-0 top-0 w-12 h-12 md:w-16 md:h-16 bg-white border-2 border-emerald-100 rounded-2xl flex items-center justify-center shadow-lg group-hover:border-emerald-600 transition-all duration-500 z-10">
                                    <span class="text-xl md:text-2xl font-black text-emerald-900 font-outfit">{{ $item->order }}</span>
                                </div>

                                <!-- Content Card -->
                                <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-emerald-50 shadow-xl shadow-emerald-900/5 group-hover:border-emerald-200 transition-all duration-500 transform group-hover:-translate-x-1">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-4">
                                        <h4 class="text-xl md:text-2xl font-extrabold text-emerald-950 font-outfit">{{ $item->title }}</h4>
                                        <span class="inline-block px-4 py-1 bg-emerald-900 text-white text-[10px] font-black rounded-full uppercase tracking-[0.2em] w-fit">
                                            {{ $item->time }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-emerald-700/70 text-sm md:text-base leading-relaxed mb-4">
                                        {!! nl2br(e($item->description)) !!}
                                    </p>

                                    @if($item->location)
                                        <div class="flex items-center gap-2 text-emerald-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-[10px] font-bold uppercase tracking-widest">{{ $item->location }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
