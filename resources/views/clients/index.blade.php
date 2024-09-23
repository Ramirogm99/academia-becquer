@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Clients')
@section('content_header_title', 'Clientes')
@section('content_header_subtitle', 'Listado de clientes')
{{-- Content body: main page content --}}


@section('content')
    {{-- add buttons --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12 pb-2">
                <a href="{{ route('clients.create') }}" class="btn btn-primary">Nuevo Cliente</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100%">
                {!! $dataTable->table(['id' => 'clients-table']) !!}
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clients-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('clients.index') }}', // Asegúrate de que esta ruta sea correcta.
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'tutor',
                        name: 'tutor'
                    },
                    {
                        data: 'school',
                        name: 'school'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
        $(document).on('click', '.delete-row', function() {
            var id = $(this).data('row-id');
            if (confirm("¿Estas seguro de querer eliminar este cliente?")) {
                $.ajax({
                    url: "/clients/delete/" + id,
                    method: 'get',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        alert(data);
                        $('#clients-table').DataTable().ajax.reload();
                    }
                });
            } else {
                return false;
            }
        });
    </script>
@endpush
