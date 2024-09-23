@extends('layouts.app')
@section('subtitle', 'courses')
@section('content_header_title', 'coursees')
@section('content_header_subtitle', $course->name)
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
                        {{ $course->name }}
                    </div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Precio/h</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $course->price }} €</div>
                </div>
                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <div class="col-3">
                        <p class="mb-0 text-lightest f-14 w-30 text-capitalize font-weight-bold">Curso</p>
                    </div>
                    <div class="mb-0 text-dark-grey f-14 w-70 text-wrap ql-editor p-0">{{ $level }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
