<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    @if(auth()->user()->can('Application Log'))
        <x-nav-link :href="route('log.app')" :active="request()->routeIs('log.app')">
            {{ __('Application') }}
        </x-nav-link>
    @endif
</div>