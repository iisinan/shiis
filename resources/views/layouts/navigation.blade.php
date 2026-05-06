<nav x-data="{ open: false }" class="bg-white border-b border-emerald-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-emerald-900">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="url('/')" :active="request()->is('/')" class="text-emerald-900">
                            {{ __('Home') }}
                        </x-nav-link>
                    @endauth

                    <x-nav-link :href="route('agenda')" :active="request()->routeIs('agenda')" class="text-emerald-900">
                        {{ __('Agenda') }}
                    </x-nav-link>
                    <x-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.*')" class="text-emerald-900">
                        {{ __('Gallery') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')" class="text-emerald-900">
                            {{ __('Colleagues') }}
                        </x-nav-link>
                    @endauth

                    @auth
                        @unless(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                            <x-nav-link :href="route('nominations.index')" :active="request()->routeIs('nominations.*')" class="text-emerald-900">
                                {{ __('Nominations') }}
                            </x-nav-link>
                            <x-nav-link :href="route('elections.index')" :active="request()->routeIs('elections.*')" class="text-emerald-900">
                                {{ __('Voting') }}
                            </x-nav-link>
                        @endunless

                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-emerald-900 font-bold">
                            {{ __('Admin') }}
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Guest Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-emerald-100 text-sm font-bold rounded-xl text-emerald-900 bg-emerald-50/50 hover:bg-emerald-50 transition duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('My Settings') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-900 hover:text-emerald-600 transition">Log in</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-emerald-900 text-white text-xs font-bold rounded-xl shadow-lg hover:bg-emerald-950 transition transform hover:-translate-y-0.5">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-emerald-900 hover:bg-emerald-50 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-emerald-50">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endauth
            
            <x-responsive-nav-link :href="route('agenda')" :active="request()->routeIs('agenda')">
                {{ __('Agenda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.*')">
                {{ __('Gallery') }}
            </x-responsive-nav-link>

            @auth
                @unless(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                    <x-responsive-nav-link :href="route('nominations.index')" :active="request()->routeIs('nominations.*')">
                        {{ __('Nominations') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('elections.index')" :active="request()->routeIs('elections.*')">
                        {{ __('Voting') }}
                    </x-responsive-nav-link>
                @endunless
                
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']))
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="font-bold text-emerald-900">
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-50">
            @auth
                <div class="px-4 mb-4">
                    <div class="font-bold text-emerald-950">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-emerald-600/60">{{ Auth::user()->email }}</div>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Settings') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="p-4 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="block text-center py-3 text-emerald-900 font-bold border border-emerald-100 rounded-xl">Log in</a>
                    <a href="{{ route('register') }}" class="block text-center py-3 bg-emerald-900 text-white font-bold rounded-xl shadow-lg">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
