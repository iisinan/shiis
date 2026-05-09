<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Shared Memories Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showUpload: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-emerald-900 p-10 rounded-[3rem] text-white shadow-2xl shadow-emerald-900/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="relative z-10 text-center md:text-left">
                    <h3 class="text-3xl font-bold font-outfit mb-2">Our Collective Journey</h3>
                    <p class="text-emerald-100/70 italic text-lg max-w-xl">"A sanctuary for the moments that defined our 21 years of brotherhood. Every photo tells a story of the Class of 2005."</p>
                </div>
                <button @click="showUpload = !showUpload" class="relative z-10 px-10 py-4 bg-white text-emerald-900 font-bold rounded-2xl shadow-xl hover:bg-emerald-50 transition transform hover:-translate-y-1">
                    Add My Memories
                </button>
            </div>

            <!-- Member Upload Form -->
            <div x-show="showUpload" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-red-800">Upload Failed</h3>
                                    <div class="mt-2 text-xs text-red-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="title" :value="__('Memory Title')" class="text-emerald-900 font-bold" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl" required placeholder="e.g. Graduation Day 2005" />
                            <p class="mt-2 text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">Give this set of photos a name.</p>
                        </div>
                        <div>
                            <x-input-label for="images" :value="__('Select Photos')" class="text-emerald-900 font-bold" />
                            <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full text-sm text-emerald-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" required accept="image/*">
                            <p class="mt-2 text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">Select up to 10 images at once.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-4 border-t border-emerald-50">
                        <button type="button" @click="showUpload = false" class="px-8 py-3 text-emerald-600 font-bold text-xs uppercase tracking-widest">Close Form</button>
                        <button type="submit" class="px-12 py-3 bg-emerald-900 text-white font-bold rounded-2xl shadow-xl hover:bg-emerald-950 transition">
                            Upload to Gallery
                        </button>
                    </div>
                </form>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($images as $img)
                    <div class="group relative bg-white rounded-[2rem] overflow-hidden shadow-lg border border-emerald-50 hover:shadow-2xl transition duration-500">
                        <div class="aspect-square relative overflow-hidden">
                            <img src="{{ route('storage.proxy', ['folder' => 'gallery', 'filename' => basename($img->image_path)]) }}" alt="{{ $img->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            
                            <!-- Delete Option (Uploader or Admin) -->
                            @if($img->user_id === auth()->id() || auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                                <form action="{{ route('gallery.destroy', $img) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-lg" onclick="return confirm('Remove this image?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="font-bold text-emerald-950 font-outfit truncate">{{ $img->title }}</h4>
                            <div class="mt-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-900 text-[10px] font-bold border border-emerald-100 shadow-inner">
                                        {{ substr($img->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-[10px] font-bold text-emerald-600/60 uppercase tracking-widest">{{ $img->user->name ?? 'Alumnus' }}</span>
                                </div>
                                <span class="text-[8px] font-bold text-emerald-300 uppercase">{{ $img->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center bg-emerald-50/50 rounded-[3rem] border border-dashed border-emerald-100">
                        <svg class="w-20 h-20 text-emerald-100 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-emerald-800/40 font-bold text-xl uppercase tracking-widest">No memories shared yet. Be the first!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $images->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
