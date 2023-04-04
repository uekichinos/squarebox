@push('css')
@endpush

@push('js')
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('role.navigation')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4 mb-3">
                <div class="col-span-6 text-xl text-gray-800">{{ __('Access') }} &raquo; {{ __('Role') }} &raquo; {{ __('Show') }}</div>
                <div class="col-span-6 space-x-8 sm:-my-px sm:ml-10 text-right"></div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid grid-cols-12 gap-4">
                        <div class="pr-5 border-r col-span-3">
                            @can('Update Role')
                                <button onclick="location.href='{{ route('role.edit', $role->id) }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg> <span>Edit Role</span>
                                </button>
                            @endcan

                            @if(auth()->user()->can('Delete Role') && $role->id != 1)
                                <form method="POST" action="{{ route('role.destroy', $role->id) }}">
                                    @csrf
                                    {{ method_field('DELETE') }}

                                    <button class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> <span>Delete</span>
                                    </button>
                                </form>
                            @endif

                            <button onclick="location.href='{{ route('role.index') }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" /></svg> <span>Back to Listing</span>
                            </button>
                        </div>
                        <div class="col-span-9">
                            @if(session()->has('success'))
                                <div notify="success" class="grid grid-cols-12 gap-4 mb-5 bg-green-100 border-l-4 border-green-500 text-green-700 py-2 pl-2" role="alert">
                                    <div class="col-span-11">
                                        <span class="font-bold">Good news!</span>&nbsp;<span class="text-md">{!! session()->get('success') !!}</span>
                                    </div>
                                    <div class="text-right mr-5"><span class="cursor-pointer" onclick="closeAlert('success')">X</span></div>
                                </div>
                            @endif
                            <div class="mb-10">
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="rolename">
                                    Name
                                </label>
                                <div>{{ ucwords($role->name) }}</div>
                            </div>
                            <div class="mb-10">
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="default">
                                    Default Assign
                                </label>
                                @if(!empty($role->default))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    <label>Set this role upon register</label>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#D1D5DB">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    <label class="text-gray-300">Set this role upon register</label>
                                @endif
                            </div>
                            <div class="mb-10">
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="rolepermission">
                                    Assign Permission
                                </label>
                                <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4">
                                    @foreach ($permissions as $name => $list)
                                        <div>
                                            <strong>{{ $name }}</strong><br>
                                            @foreach ($list as $permission)
                                                @if($permission['tag'] === true)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <label> {{ $permission['name'] }}</label>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#D1D5DB">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <label class="text-gray-300"> {{ $permission['name'] }}</label>
                                                @endif
                                                <br>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="created">
                                        Created At
                                    </label>
                                    <div class="font-bold">{{ $role->created_at }}</div>
                                </div>
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="updated">
                                        Updated At
                                    </label>
                                    <div class="font-bold">{{ $role->updated_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>