@extends('layouts.app')
{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Inicio')
@section('content_header_subtitle', 'Bienvenido Administrador')


{{-- Content body: main page content --}}

@section('content_body')
    {{-- add buttons --}}
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center">Bienvenido Administrador</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title
                                        ">Clientes</h5>
                                        <p class="card-text">Total de recaudado hoy: {{ $revenueToday }} €</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title
                                        ">Clientes</h5>
                                        <p class="card-text">Total de recaudado este mes: {{ $revenueMonth }} €</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
@endpush
