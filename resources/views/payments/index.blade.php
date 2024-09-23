@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Pagos')
@section('content_header_title', 'Pagos')
@section('content_header_subtitle', 'Listado de Pagos')
{{-- Content body: main page content --}}


@section('content')
    {{-- add buttons --}}
    <div class="container">
        {{-- {!! $dataTable->table(['id' => 'payments-table']) !!} --}}
        @foreach ($courseClients as $item)
            <div class="card">
                <div class="card-body" style="width: 100%">
                    <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                        <div class="col-4">
                            <div class="mb-0  mt-2 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                                <b> {{ $item->client->name }}</b>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-0  mt-2 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                                Total a pagar :
                                {{ App\Models\ClientCourse::where('client_id', $item->client->id)->sum('total') }}
                            </div>
                        </div>
                        <div class="dropdown col-4">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="dropdownMenuLink-{{ $item->id }}" tabindex="0">
                                <a href="javascript:;" class="dropdown-item make-payment"
                                    data-row-id="{{ $item->client->id }}"><i class="fa fa-pen mr-2"></i>Realizar pago
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
            $('#payments-table').DataTable({
                searching: false,
                processing: true,
                serverSide: true,
                orderable: true,
            });
            $('#payments-table').DataTable().draw();
        });
        // $(document).on('click', '.delete-row', function() {
        //     var id = $(this).data('row-id');
        //     if (confirm("¿Estas seguro de querer eliminar este pago?")) {
        //         $.ajax({
        //             url: "/payments/delete/" + id,
        //             method: 'get',
        //             data: {
        //                 id: id
        //             },
        //             success: function(data) {
        //                 alert(data);
        //                 $('#payments-table').DataTable().ajax.reload();
        //             }
        //         });
        //     } else {
        //         return false;
        //     }
        // });
        $(document).on('click', '.make-payment', function() {
            var id = $(this).data('row-id');
            $.ajax({
                url: "/payments/paydone/" + id,
                method: 'get',
                success: function(data) {
                    location.reload();
                }
            });
        });
        // $('#payments-table').on('preXhr.dt', function(e, settings, data) {

        //     const searchText_filter = $('#search-text-field').val();
        //     data['searchText'] = searchText_filter;
        //     $('#payments-table').DataTable().draw();
        // });
    </script>
@endpush
