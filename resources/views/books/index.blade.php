<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-6 gap4">
            <div class="col-start-1 col-end-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Billing') }}
                </h2>
            </div>
            <div class="col-end-13 col-span-1">
                <x-anchor link="{{ route('book.new') }}">
                    {{ __('New Book') }}
                </x-anchor>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto border border-collapse w-max" id="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Books Number</td>
                                <td>Name</td>
                                <td>Release Date</td>
                                <td>Created At</td>
                                <td>Created By</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            var table;
            const columns = [
                { data: 'DT_RowIndex', name : 'id' },
                { data: 'number' , name : 'number'},
                { data: 'name' , name : 'name'},
                { data: 'release' , name : 'release'},
                { data: 'created_at' , name : 'created_at' },
                { data: 'maker.name' , name : 'maker.name' },
                { data: 'actions' , name : 'actions', orderable : false, searchable: false },
            ];

            $(document).ready(function() {
                table = $('#table').DataTable({
                    stateSave: true,
                    responsive: true,
                    processing: true,
                    serverSide : true,
                    ajax    : {
                        url: '{{ route("book.datas") }}',
                        method: 'POST'
                    },
                    columns : columns,
                    'columnDefs': [
                        {
                            'targets': columns.length - 1,
                            'createdCell':  function (td, cellData, rowData, row, col) {
                                $(td).attr('align', 'center');
                            }
                        }
                    ]
                });
            });

            function deleteItem(id){
                swal.fire({
                    title : "Perhatian!",
                    html : "Data barang tidak dapat dikembalikan",
                    icon : "info",
                    showCancelButton : true,
                    showLoaderOnConfirm : true,
                    preConfirm : () => {
                        return fetch("{{ url('books/delete') }}/" + id)
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText);
                            }
                            return response.json()
                        })
                        .then(data => {
                            if(data.result == "error"){
                                swal.showValidationMessage(data.title);
                            }
                        })
                        .catch(error => {
                            swal.showValidationMessage("Terjadi kesalahan dalam menghapus data");
                        })
                    },
                    allowOutsideClick : () => !swal.isLoading()
                }).then((result) => {
                    if(result.value){
                        swal.fire({
                            title : "Success!",
                            text : "Data telah berhasil dihapus",
                            icon : "success",
                            timer : 2000,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        }).then((result) => {
                            if(result.dismiss === Swal.DismissReason.timer){
                                table.ajax.reload(null, false);
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot name="scripts">
</x-app-layout>
