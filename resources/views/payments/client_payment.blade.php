@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Pagos')
@section('content_header_title', 'Pagos')
@section('content_header_subtitle', 'Listado de Pagos')
{{-- Content body: main page content --}}
@php
@endphp
@section('content')
    {{-- add buttons --}}
    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100%">
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-4">
                        <div class="mb-0  mt-2 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                            <select name="months" id="months" class="form-control select-picker">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-0  mt-3 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                            <span>{{ $client->name }}
                                {{ $client->surnames }}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-0  mt-3 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                            <span id="prices">
                                Total a Abonar :
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="mb-0 mt-3 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                            <span id="courses-to-pay">
                                Cursos a Abonar : <b><span id="courses"></span></b>
                            </span>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <div class=" mt-4 p-2">
                            <button type="button" class="btn btn-secondary" id="make-payment">Realizar Pago</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#months').on('change', function() {
                var month = $(this).val();
                $('#courses-to-pay').html('Cursos a Abonar :  <b><span id="courses"></span></b>');
                $.ajax({
                    url: "{{ route('payments.getPrices') }}",
                    type: 'GET',
                    data: {
                        month: month,
                        client_id: {{ $client->id }}
                    },
                    success: function(data) {
                        let Alldata = JSON.parse(data);
                        console.log(Alldata);
                        if (Alldata.price == 0) {
                            $('#prices').html('Total a pagar : 0.00 (PAGADO)');
                            $('#make-payment').attr('disabled', true);
                        } else {
                            $('#make-payment').attr('disabled', false);
                            $('#prices').html('Total a pagar : ' + Alldata.price + ' €');
                            Alldata.courses.forEach(element => {
                                $('#courses').append('<ul>' +
                                    '<li>' +
                                    element.course.name +
                                    '</li>' +
                                    '</ul>');
                            });
                        }
                    }
                });
            });
            $('#make-payment').on('click', function() {
                var month = $('#months').val();
                $.ajax({
                    url: "{{ route('payments.makeAPaymentClient') }}",
                    type: 'GET',
                    data: {
                        month: month,
                        client_id: {{ $client->id }}
                    },
                    success: function(data) {
                        let Alldata = JSON.parse(data);
                        console.log(Alldata);
                        if (Alldata.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pago Realizado',
                                text: 'El pago se ha realizado correctamente',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ha ocurrido un error al realizar el pago',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
