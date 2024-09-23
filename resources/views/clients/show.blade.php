@extends('layouts.app')
@section('subtitle', 'Clients')
@section('content_header_title', 'Clientes')
@section('content_header_subtitle', $client->name)
{{-- Content body: main page content --}}


@section('content')
    {{-- add buttons --}}

    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100%">
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Nombre</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 col-6">
                        {{ $client->name }}
                    </div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Tutor</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $client->tutor }}</div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Teléfono</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $client->phone }}</div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Nivel Académico</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $level }}</div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Colegio</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $client->school }}</div>
                </div>
                @if (isset($courses))
                    <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                        <div class="col-3">
                            <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Cursos a los que
                                asiste:</p>
                        </div>
                        @foreach ($courses as $course)
                            <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0 ml-1">{{ $course->course->name }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
