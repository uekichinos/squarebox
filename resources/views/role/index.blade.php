@push('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/overwrite-table.css') }}" rel="stylesheet">
@endpush

@push('js')
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript">
    $(function () {
    
        var table = $('#list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('role.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });
    
    });
    </script>
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
                <div class="col-span-6 text-xl text-gray-800">{{ __('Access') }} &raquo; {{ __('Role') }}</div>
                <div class="col-span-6 space-x-8 sm:-my-px sm:ml-10 text-right"></div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-2">
                            @can('Create Role')
                                <button onclick="location.href='{{ route('role.create') }}'" class="bg-gray-700 hover:bg-gray-500 text-white py-2 px-4 border border-gray-700 rounded mb-5 w-auto text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> <span>New Record</span>
                                </button>
                            @endcan
                        </div>
                        <div class="col-span-10">
                            @if(session()->has('success'))
                                <div notify="success" class="grid grid-cols-12 gap-4 mb-5 bg-green-100 border-l-4 border-green-500 text-green-700 py-2 pl-2" role="alert">
                                    <div class="col-span-11">
                                        <span class="font-bold">Good news!</span>&nbsp;<span class="text-md">{!! session()->get('success') !!}</span>
                                    </div>
                                    <div class="text-right mr-5"><span class="cursor-pointer" onclick="closeAlert('success')">X</span></div>
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div notify="error" class="grid grid-cols-12 gap-4 mb-5 bg-red-100 border-l-4 border-red-500 text-red-700 py-2 pl-2" role="alert">
                                    <div class="col-span-11">
                                        <span class="font-bold">Opss!</span>&nbsp;<span class="text-md">{!! session()->get('error') !!}</span>
                                    </div>
                                    <div class="text-right mr-5"><span class="cursor-pointer" onclick="closeAlert('error')">X</span></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <table id="list-table" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr>
                                <th width="10%" style="text-align:left">No</th>
                                <th style="text-align:left">Name</th>
                                <th width="12%" style="text-align:left"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>