<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    @if(auth()->user()->can('Analytics Setting'))
        <x-nav-link :href="route('setting.ga.edit')" :active="request()->routeIs('setting.ga.edit')">
            {{ __('Google Analytics') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('Announcement Setting'))
        <x-nav-link :href="route('setting.announce.edit')" :active="request()->routeIs('setting.announce.edit')">
            {{ __('Announcement') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('Maintenance Setting'))
        <x-nav-link :href="route('setting.maintenance.edit')" :active="request()->routeIs('setting.maintenance.edit')">
            {{ __('Maintenance') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('Password Setting'))
        <x-nav-link :href="route('setting.password.edit')" :active="request()->routeIs('setting.password.edit')">
            {{ __('Password') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('Header Setting'))
        <x-nav-link :href="route('setting.header.edit')" :active="request()->routeIs('setting.header.edit')">
            {{ __('Header') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('Agent Setting'))
        <x-nav-link :href="route('setting.agent.edit')" :active="request()->routeIs('setting.agent.edit')">
            {{ __('Browser Agent') }}
        </x-nav-link>
    @endif
</div>