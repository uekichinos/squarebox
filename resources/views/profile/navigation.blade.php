<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-nav-link>
    <x-nav-link :href="route('passwd.edit')" :active="request()->routeIs('passwd.edit')">Password</x-nav-link>
    <x-nav-link :href="route('picture.edit')" :active="request()->routeIs('picture.edit')">Picture</x-nav-link>
</div>
