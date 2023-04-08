@impersonating($guard = null)
    <!-- impersonate revert -->
    <nav class="border-b border-gray-100 text-center p-3 bg-yellow-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <a href="{{ route('user.leaveimpersonate') }}">{{ __('Exit impersonation') }}</a>
    </nav>
@endImpersonating

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" src="{{ $headers['image'] }}">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard.index')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(auth()->user()->can('List User') || auth()->user()->can('Create User') || auth()->user()->can('Update User') || auth()->user()->can('View User') || auth()->user()->can('Delete User') || auth()->user()->can('List Role') || auth()->user()->can('Create Role') || auth()->user()->can('Update Role') || auth()->user()->can('View Role') || auth()->user()->can('Delete Role') || auth()->user()->can('List Permission'))
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index') || request()->routeIs('user.create') || request()->routeIs('user.show') || request()->routeIs('user.edit') || request()->routeIs('role.index') || request()->routeIs('role.create') || request()->routeIs('role.show') || request()->routeIs('role.edit') || request()->routeIs('permission.index')">
                            {{ __('Access') }}
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->can('Analytics Setting') || auth()->user()->can('Password Setting') || auth()->user()->can('Announcement Setting') || auth()->user()->can('Maintenance Setting') || auth()->user()->can('Header Setting') || auth()->user()->can('Agent Setting'))
                        <x-nav-link :href="route('setting.ga.edit')" :active="request()->routeIs('setting.ga.edit') || request()->routeIs('setting.password.edit') || request()->routeIs('setting.announce.edit') || request()->routeIs('setting.maintenance.edit') || request()->routeIs('setting.header.edit') || request()->routeIs('setting.agent.edit')">
                            {{ __('Settings') }}
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->can('Application Log'))
                        <x-nav-link :href="route('log.app')" :active="request()->routeIs('log.app')">
                            {{ __('Logs') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <img src="{{ asset('storage/img/avatars/'.Auth::user()->picture) }}" class="w-10 h-10 float-left rounded-full mr-4">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard.index')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(auth()->user()->can('List User') || auth()->user()->can('Create User') || auth()->user()->can('Update User') || auth()->user()->can('View User') || auth()->user()->can('Delete User') || auth()->user()->can('List Role') || auth()->user()->can('Create Role') || auth()->user()->can('Update Role') || auth()->user()->can('View Role') || auth()->user()->can('Delete Role') || auth()->user()->can('List Permission'))
                <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user.index') || request()->routeIs('user.create') || request()->routeIs('user.show') || request()->routeIs('user.edit') || request()->routeIs('role.index') || request()->routeIs('role.create') || request()->routeIs('role.show') || request()->routeIs('role.edit') || request()->routeIs('permission.index')">
                    {{ __('Access') }}
                </x-responsive-nav-link>
            @endif
            @if(auth()->user()->can('Analytics Setting') || auth()->user()->can('Password Setting') || auth()->user()->can('Announcement Setting') || auth()->user()->can('Maintenance Setting') || auth()->user()->can('Header Setting') || auth()->user()->can('Agent Setting'))
                <x-responsive-nav-link :href="route('setting.ga.edit')" :active="request()->routeIs('setting.ga.edit') || request()->routeIs('setting.password.edit') || request()->routeIs('setting.announce.edit') || request()->routeIs('setting.maintenance.edit') || request()->routeIs('setting.header.edit') || request()->routeIs('setting.agent.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
            @endif
            @if(auth()->user()->can('Application Log'))
                <x-responsive-nav-link :href="route('log.app')" :active="request()->routeIs('log.app')">
                    {{ __('Logs') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <img src="{{ asset('storage/img/avatars/'.Auth::user()->picture) }}" class="w-10 h-10 float-left rounded-full mr-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
