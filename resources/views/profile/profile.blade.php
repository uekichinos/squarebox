@push('css')
@endpush

@push('js')
    <script src="{{ asset('js/custom.js') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('profile.navigation')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4 mb-3">
                <div class="col-span-6 text-xl text-gray-800">{{ __('Update Profile') }}</div>
                <div class="col-span-6 space-x-8 sm:-my-px sm:ml-10 text-right"></div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('profile.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-4">
                            <div class="pr-5 border-r col-span-3">
                                <button type="submit" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded text-left w-full mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> <span>Update</span>
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
                                    <label class="block text-gray-700 text-sm mb-2" for="name">
                                        Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" type="text" value="{{ $user->name }}">
                                    @error('name')
                                        <div notify="name" class="bg-red-100 border-l-4 border-red-500 text-red-700 py-1 pl-2 my-2 text-sm">{{ $message }} <span class="cursor-pointer float-right mr-2" onclick="closeAlert('name')">X</span></div>
                                    @enderror
                                </div>
                                <div class="mb-10">
                                    <label class="block text-gray-700 text-sm mb-2" for="email">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" type="text" value="{{ $user->email }}">
                                    @error('email')
                                        <div notify="email" class="bg-red-100 border-l-4 border-red-500 text-red-700 py-1 pl-2 my-2 text-sm">{{ $message }} <span class="cursor-pointer float-right mr-2" onclick="closeAlert('email')">X</span></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>