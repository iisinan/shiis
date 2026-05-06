<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Reunion Agenda Manager') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        showEdit: false,
        editData: { id: '', time: '', title: '', description: '', location: '', order: 0 },
        openEdit(item) {
            this.editData = { ...item };
            this.showEdit = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left: Control Panel -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-emerald-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-emerald-900/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold font-outfit mb-4">Agenda Control</h3>
                        <p class="text-emerald-100/70 text-sm italic leading-relaxed">"Curate the perfect experience for the Class of 2005. Changes reflect instantly on the public timeline."</p>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                        <h4 class="text-lg font-bold text-emerald-950 font-outfit mb-6">Create New Slot</h4>
                        <form action="{{ route('admin.agenda.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="time" :value="__('Time Slot')" class="text-emerald-900 font-bold text-xs mb-1" />
                                <x-text-input id="time" name="time" type="text" class="block w-full border-emerald-50 focus:ring-emerald-500 rounded-xl text-sm" required placeholder="09:00 AM" />
                            </div>
                            <div>
                                <x-input-label for="title" :value="__('Title')" class="text-emerald-900 font-bold text-xs mb-1" />
                                <x-text-input id="title" name="title" type="text" class="block w-full border-emerald-50 focus:ring-emerald-500 rounded-xl text-sm" required placeholder="Opening Ceremony" />
                            </div>
                            <div>
                                <x-input-label for="location" :value="__('Location')" class="text-emerald-900 font-bold text-xs mb-1" />
                                <x-text-input id="location" name="location" type="text" class="block w-full border-emerald-50 focus:ring-emerald-500 rounded-xl text-sm" placeholder="Main Hall" />
                            </div>
                            <div>
                                <x-input-label for="order" :value="__('Sort Order')" class="text-emerald-900 font-bold text-xs mb-1" />
                                <x-text-input id="order" name="order" type="number" class="block w-full border-emerald-50 focus:ring-emerald-500 rounded-xl text-sm" value="0" required />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Short Description')" class="text-emerald-900 font-bold text-xs mb-1" />
                                <textarea name="description" rows="3" class="block w-full border-emerald-50 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl text-sm text-emerald-900" placeholder="A brief overview..."></textarea>
                            </div>
                            <x-primary-button class="w-full justify-center py-4 bg-emerald-900 hover:bg-emerald-950 rounded-xl shadow-lg">
                                Add to Timeline
                            </x-primary-button>
                        </form>
                    </div>
                </div>

                <!-- Right: Timeline Preview & Management -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                        <div class="flex justify-between items-center mb-10">
                            <h3 class="text-2xl font-bold text-emerald-950 font-outfit">Live Timeline</h3>
                            <span class="px-4 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-full border border-emerald-100 uppercase tracking-widest">
                                {{ $agendas->count() }} Total Items
                            </span>
                        </div>

                        <div class="space-y-6">
                            @forelse($agendas as $item)
                                <div class="p-6 bg-emerald-50/30 border border-emerald-50 rounded-3xl group hover:bg-white hover:border-emerald-200 hover:shadow-xl transition duration-500">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                        <div class="flex items-center gap-6 flex-1">
                                            <div class="w-20 py-2 bg-emerald-900 text-white text-[10px] font-black rounded-xl text-center shadow-lg uppercase tracking-wider">
                                                {{ $item->time }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-emerald-950 text-lg font-outfit">{{ $item->title }}</h4>
                                                <p class="text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">{{ $item->location ?? 'No Location Set' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-3">
                                            <button @click="openEdit({{ json_encode($item) }})" class="p-3 bg-white text-emerald-600 border border-emerald-100 rounded-xl hover:bg-emerald-900 hover:text-white transition shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            
                                            <form action="{{ route('admin.agenda.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-3 bg-white text-red-400 border border-emerald-100 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm" onclick="return confirm('Archive this slot?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-emerald-50/50 hidden group-hover:block transition duration-500">
                                        <p class="text-sm text-emerald-700/60 leading-relaxed italic">"{{ $item->description ?: 'No description provided.' }}"</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20 bg-emerald-50/30 rounded-3xl border border-dashed border-emerald-100">
                                    <p class="text-emerald-800/40 font-black uppercase tracking-[0.2em]">The timeline is empty</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEdit" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-emerald-950/80 backdrop-blur-sm" @click="showEdit = false"></div>
                
                <div class="bg-white rounded-[2.5rem] p-10 max-w-xl w-full relative z-10 border border-emerald-100 shadow-2xl">
                    <h3 class="text-2xl font-bold text-emerald-950 font-outfit mb-8">Update Agenda Slot</h3>
                    
                    <form :action="'{{ url('admin/agenda') }}/' + editData.id" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Time Slot" />
                                <x-text-input name="time" x-model="editData.time" class="block w-full border-emerald-100" required />
                            </div>
                            <div>
                                <x-input-label value="Sort Order" />
                                <x-text-input name="order" type="number" x-model="editData.order" class="block w-full border-emerald-100" required />
                            </div>
                        </div>
                        <div>
                            <x-input-label value="Title" />
                            <x-text-input name="title" x-model="editData.title" class="block w-full border-emerald-100" required />
                        </div>
                        <div>
                            <x-input-label value="Location" />
                            <x-text-input name="location" x-model="editData.location" class="block w-full border-emerald-100" />
                        </div>
                        <div>
                            <x-input-label value="Description" />
                            <textarea name="description" x-model="editData.description" rows="4" class="block w-full border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl text-emerald-900"></textarea>
                        </div>
                        
                        <div class="flex justify-end gap-4">
                            <button type="button" @click="showEdit = false" class="px-8 py-3 text-emerald-900 font-bold border border-emerald-100 rounded-xl hover:bg-emerald-50 transition">Cancel</button>
                            <x-primary-button class="bg-emerald-900 px-8 py-3 rounded-xl shadow-lg">Save Changes</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
