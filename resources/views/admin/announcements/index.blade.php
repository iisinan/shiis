<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">
            {{ __('Broadcast Center') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showForm: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Action Header -->
            <div class="flex justify-between items-center bg-emerald-900 p-8 rounded-[2rem] text-white shadow-2xl shadow-emerald-900/20">
                <div>
                    <h3 class="text-2xl font-bold font-outfit">Manage Updates</h3>
                    <p class="text-emerald-100/60 text-sm italic">"Keep the fraternity informed with real-time broadcasts."</p>
                </div>
                <button @click="showForm = !showForm" class="px-8 py-3 bg-white text-emerald-900 font-bold rounded-2xl shadow-lg hover:bg-emerald-50 transition">
                    New Broadcast
                </button>
            </div>

            <!-- New Announcement Form -->
            <div x-show="showForm" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[2.5rem] p-10 border border-emerald-100 shadow-xl shadow-emerald-900/5">
                <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" :value="__('Headline')" class="text-emerald-900 font-bold" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl" required placeholder="e.g. Election Polls Now Open!" />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Category')" class="text-emerald-900 font-bold" />
                            <select name="type" id="type" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl text-sm text-emerald-900" required>
                                <option value="info">General Info (Emerald)</option>
                                <option value="important">Important (Red)</option>
                                <option value="success">Celebration (Green)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="content" :value="__('Message Content')" class="text-emerald-900 font-bold" />
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-2xl text-emerald-900" required placeholder="Details about the update..."></textarea>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" @click="showForm = false" class="px-8 py-3 text-emerald-600 font-bold text-xs uppercase tracking-widest">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-emerald-900 text-white font-bold rounded-2xl shadow-xl hover:bg-emerald-950 transition">
                            Broadcast Now
                        </button>
                    </div>
                </form>
            </div>

            <!-- Announcements List -->
            <div class="bg-white rounded-[2.5rem] border border-emerald-100 shadow-xl shadow-emerald-900/5 overflow-hidden">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-emerald-50">
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Status</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50">Broadcast</th>
                                    <th class="py-5 px-4 font-bold text-[10px] uppercase tracking-[0.2em] text-emerald-600/50 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($announcements as $ann)
                                    <tr class="hover:bg-emerald-50/30 transition group">
                                        <td class="py-6 px-4">
                                            <form action="{{ route('admin.announcements.toggle', $ann) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 {{ $ann->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} text-[10px] font-bold rounded-full border border-emerald-100 uppercase tracking-widest">
                                                    <div class="w-1 h-1 {{ $ann->is_published ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full animate-pulse"></div>
                                                    {{ $ann->is_published ? 'Live' : 'Hidden' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-6 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-2 h-10 {{ $ann->type == 'important' ? 'bg-red-500' : ($ann->type == 'success' ? 'bg-emerald-500' : 'bg-blue-500') }} rounded-full"></div>
                                                <div>
                                                    <h4 class="font-bold text-emerald-950">{{ $ann->title }}</h4>
                                                    <p class="text-xs text-emerald-800/60 mt-1 line-clamp-1">{{ $ann->content }}</p>
                                                    <p class="text-[10px] text-emerald-600/40 font-bold uppercase mt-1">{{ $ann->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 px-4 text-right">
                                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition">
                                                <form action="{{ route('admin.announcements.destroy', $ann) }}" method="POST" onsubmit="return confirm('Delete this broadcast?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-300 hover:text-red-600 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-20 text-center text-emerald-200 italic font-bold uppercase tracking-widest">No broadcasts history.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
