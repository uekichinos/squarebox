<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    @if(auth()->user()->can('List User') || auth()->user()->can('Create User') || auth()->user()->can('Update User') || auth()->user()->can('View User') || auth()->user()->can('Delete User'))
        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index') || request()->routeIs('user.create') || request()->routeIs('user.show') || request()->routeIs('user.edit') || request()->routeIs('user.edit') || request()->routeIs('user.editpassword')">
            {{ __('User') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('List Role') || auth()->user()->can('Create Role') || auth()->user()->can('Update Role') || auth()->user()->can('View Role') || auth()->user()->can('Delete Role'))
        <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.index') || request()->routeIs('role.create') || request()->routeIs('role.show') || request()->routeIs('role.edit')">
            {{ __('Role') }}
        </x-nav-link>
    @endif
    @if(auth()->user()->can('List Permission'))
        <x-nav-link :href="route('permission.index')" :active="request()->routeIs('permission.index')">
            {{ __('Permission') }}
        </x-nav-link>
    @endif
</div>