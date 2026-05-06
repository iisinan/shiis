<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Gallery Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Upload Box -->
            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-emerald-900/5 p-10 border border-emerald-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-emerald-950 font-outfit">Bulk Memory Uploader</h3>
                        <p class="text-xs text-emerald-600/50 font-bold uppercase tracking-widest mt-1">Add multiple pictures to the gallery at once</p>
                    </div>
                </div>

                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ filesCount: 0 }">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" :value="__('Common Title / Event Name')" class="text-emerald-900 font-bold mb-1" />
                            <x-text-input id="title" class="block mt-1 w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl shadow-sm" type="text" name="title" required placeholder="e.g. 2005 Class Dinner" />
                        </div>
                        <div>
                            <x-input-label for="images" :value="__('Select Pictures')" class="text-emerald-900 font-bold mb-1" />
                            <div class="relative">
                                <label for="images" class="block w-full px-4 py-3 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-2xl border-2 border-dashed border-emerald-200 cursor-pointer hover:bg-emerald-100 transition text-center">
                                    <span x-text="filesCount > 0 ? filesCount + ' files selected' : 'Click to browse files (Max 20 at a time)...'"></span>
                                </label>
                                <input id="images" class="hidden" type="file" name="images[]" multiple required @change="filesCount = $event.target.files.length" accept="image/*" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <x-primary-button class="px-10 py-4 bg-emerald-900 hover:bg-emerald-950 shadow-xl rounded-2xl transition transform hover:-translate-y-1">
                            Process Uploads
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Photos Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($images as $img)
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-xl shadow-emerald-900/5 border border-emerald-50 group relative">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $img->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-emerald-950/20 group-hover:bg-transparent transition duration-500"></div>
                        </div>
                        <div class="p-6">
                            <p class="text-emerald-950 font-bold font-outfit truncate">{{ $img->title }}</p>
                            <p class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest mt-1">{{ $img->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <!-- Actions -->
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition duration-300">
                            <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-red-600 text-white rounded-2xl hover:bg-red-700 shadow-2xl transform hover:scale-110 transition" onclick="return confirm('Delete this image permanently?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-emerald-100">
                        <p class="text-emerald-800/30 font-bold uppercase tracking-[0.2em]">Gallery is empty</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
