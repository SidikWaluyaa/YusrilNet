<nav x-data="{ open: false, profileOpen: false }" class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="transition-transform hover:scale-105">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>

                @if (auth()->user()->role === 'admin')
                    <!-- Navigation Links for Admin -->
                    <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                {{ __('Dashboard') }}
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('pakets.index')" :active="request()->routeIs('pakets.index')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('pakets.index') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('Pakets') }}
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('vouchers.index')" :active="request()->routeIs('vouchers.index')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('vouchers.index') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                                </svg>
                                {{ __('Vouchers') }}
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('orders.index') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('Orders') }}
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('users.index') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('User') }}
                            </span>
                        </x-nav-link>
                    </div>
                @elseif(auth()->user()->role === 'user')
                    <!-- Navigation Links for User -->
                    <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                        <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                {{ __('Dashboard') }}
                            </span>
                        </x-nav-link>
                        <x-nav-link :href="route('orders.my')" :active="request()->routeIs('orders.my')"
                            class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/20 transition-colors duration-200 {{ request()->routeIs('orders.my') ? 'bg-white/20 font-bold' : '' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('Orderan Saya') }}
                            </span>
                        </x-nav-link>
                    </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-full text-white hover:bg-white/20 focus:outline-none transition duration-150 ease-in-out bg-white/10 backdrop-blur-sm">
                        <div class="mr-2">{{ Auth::user()->name }}</div>
                        <div
                            class="bg-white text-indigo-600 rounded-full h-8 w-8 flex items-center justify-center font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-lg shadow-xl z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 rounded-md mx-2 transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('Profile') }}
                        </a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700 rounded-md mx-2 transition-colors duration-150 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-white/20 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 px-2">
            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pakets.index')" :active="request()->routeIs('pakets.index')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('pakets.index') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Pakets') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('vouchers.index')" :active="request()->routeIs('vouchers.index')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('vouchers.index') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                        </svg>
                        {{ __('Vouchers') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('orders.index') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Orders') }}
                    </span>
                </x-responsive-nav-link>
            @elseif(auth()->user()->role === 'user')
                <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('user.dashboard') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.my')" :active="request()->routeIs('orders.my')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20 {{ request()->routeIs('orders.my') ? 'bg-white/20' : '' }}">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Orderan Saya') }}
                    </span>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4 flex items-center">
                <div
                    class="bg-white text-indigo-600 rounded-full h-10 w-10 flex items-center justify-center font-bold uppercase mr-3">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white/70">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/20">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Profile') }}
                    </span>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-red-500">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('Log Out') }}
                        </span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
