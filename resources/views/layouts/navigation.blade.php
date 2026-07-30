<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-[#041B4A] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('logo_hitam.png') }}" alt="ARTIX ID" class="block h-9 w-auto dark:hidden">
                        <img src="{{ asset('logo_putih.png') }}" alt="ARTIX ID" class="hidden h-9 w-auto dark:block" style="filter: drop-shadow(0px 0px 8px rgba(0, 102, 255, 0.5));">
                    </a>
                </div>

                <!-- Tautan Menu Kiri Desktop -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')" class="dark:text-white/70 dark:hover:text-white">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="dark:text-white/70 dark:hover:text-white">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Dropdown Profil Kanan Desktop -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-slate-500 bg-white hover:text-slate-700 dark:bg-transparent dark:text-white/70 dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>Halo, {{ explode(' ', Auth::user()->name)[0] }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Link Profil -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <!-- LINK RIWAYAT PESANAN (BARU) -->
                        <x-dropdown-link :href="route('transaction.history')">
                            {{ __('Riwayat Pesanan') }}
                        </x-dropdown-link>

                        <!-- Link Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-500 hover:text-red-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Tombol Hamburger Mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden dark:bg-[#020C1F]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')" class="dark:text-white/70">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'eo')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="dark:text-white/70">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-white/10">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800 dark:text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500 dark:text-white/50">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Link Profil -->
                <x-responsive-nav-link :href="route('profile.edit')" class="dark:text-white/70">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <!-- LINK RIWAYAT PESANAN MOBILE (BARU) -->
                <x-responsive-nav-link :href="route('transaction.history')" class="dark:text-white/70">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>

                <!-- Link Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-500 hover:text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
