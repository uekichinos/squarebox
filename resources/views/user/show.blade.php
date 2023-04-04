@push('css')
@endpush

@push('js')
    <script src="{{ asset('js/custom.js') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('user.navigation')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4 mb-3">
                <div class="col-span-6 text-xl text-gray-800">{{ __('Access') }} &raquo; {{ __('User') }} &raquo; {{ __('Show') }}</div>
                <div class="col-span-6 space-x-8 sm:-my-px sm:ml-10 text-right"></div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
    
                    <div class="grid grid-cols-12 gap-4">
                        <div class="pr-5 border-r col-span-3">
                            @can('Update User')
                                <button onclick="location.href='{{ route('user.edit', $user->id) }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg> <span>Edit Profile</span>
                                </button>
                                <button onclick="location.href='{{ route('user.editpassword', $user->id) }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg> <span>Edit Password</span>
                                </button>
                            @endcan

                            @if(auth()->user()->can('Delete User') && Auth::user()->id != $user->id)
                                <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> <span>Delete</span>
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->can('Impersonate User') && Auth::user()->id != $user->id)
                                <button onclick="location.href='{{ route('user.takeimpersonate', $user->id) }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> <span>Impersonate</span>
                                </button>
                            @endif

                            <button onclick="location.href='{{ route('user.index') }}'; return false;" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
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
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="name">
                                    Name
                                </label>
                                <div class="font-bold">{{ $user->name }} {!! (Cache::get('user-is-online-'.$user->id) === true ? ' <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z" /></svg>' : '') !!}</div>
                            </div>
                            <div class="mb-10">
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="role">
                                    Role
                                </label>
                                <div class="font-bold">{{ ucwords($role) }}</div>
                            </div>
                            <div class="mb-10">
                                <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="email">
                                    Email
                                </label>
                                <div class="font-bold">{{ $user->email }}</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="created">
                                        Created At
                                    </label>
                                    <div class="font-bold">{{ $user->created_at }}</div>
                                </div>
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="updated">
                                        Updated At
                                    </label>
                                    <div class="font-bold">{{ $user->updated_at }}</div>
                                </div>
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2 border-b border-dashed" for="password_updated">
                                        Last Password Updated At
                                    </label>
                                    <div class="font-bold">{{ $user->password_updated_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>