@push('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/overwrite-table.css') }}" rel="stylesheet">
@endpush

@push('js')
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript">
    $(function () {
        var table = $('#list-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permission.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
            ]
        });
    
    });
    </script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @include('permission.navigation')
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4 mb-3">
                <div class="col-span-6 text-xl text-gray-800">{{ __('Access') }} &raquo; {{ __('Permission') }}</div>
                <div class="col-span-6 space-x-8 sm:-my-px sm:ml-10 text-right"></div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="list-table" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                        <thead>
                            <tr>
                                <th width="10%" style="text-align:left">No</th>
                                <th style="text-align:left">Name</th>
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