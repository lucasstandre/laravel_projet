<nav x-data="{ open: false }" class="bg-[#000d1a] border-b border-white/10 shadow-2xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 md:h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl md:text-3xl font-black tracking-tighter text-yellow-500">
                        SONORA
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 hover:text-yellow-500 transition-colors uppercase text-[10px] font-black tracking-widest">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('playlists')" :active="request()->routeIs('playlists')" class="text-gray-400 hover:text-yellow-500 transition-colors uppercase text-[10px] font-black tracking-widest">
                        {{ __('Playlists') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-gray-400 hover:text-yellow-500 transition-colors uppercase text-[10px] font-black tracking-widest">
                        {{ __('Utilisateurs') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/10 text-sm font-bold rounded-xl text-gray-300 bg-white/5 hover:bg-white/10 transition-all">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-1 fill-current h-4 w-4 text-yellow-500" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#001a33] border border-white/10 rounded-lg overflow-hidden shadow-2xl">

                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-white/5">
                                {{ __('Profil') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('statistique.user', ['id' => Auth::id()])" class="text-yellow-500 hover:bg-white/5 font-bold border-b border-white/5">
                                {{ __('Mes Stats') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 hover:bg-red-500/10">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="text-yellow-500 p-2">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#000d1a] border-t border-white/5">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('playlists')" :active="request()->routeIs('playlists')" class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Playlists</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Utilisateurs</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-white/5">
            <div class="px-4 py-2 border-b border-white/5 mb-2">
                <x-responsive-nav-link :href="route('statistique.user', ['id' => Auth::id()])" class="text-yellow-500 font-black italic">MES STATISTIQUES</x-responsive-nav-link>
            </div>
            <div class="px-4">
                <div class="font-bold text-base text-gray-200">{{ Auth::user()->name }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400">Profil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">Déconnexion</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
