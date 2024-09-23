@extends('layouts.app')
@section('subtitle', 'Clients')
@section('content_header_title', 'Clientes')
@section('content_header_subtitle', 'Creación de clientes')
{{-- Content body: main page content --}}


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100% ; height : 100%;">
                <form action="{{ route('courses.update') }}" method="POST">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="form-group col-3
                        @error('name') has-error @enderror">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $course->name }}">
                            @error('name')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('tutor') has-error @enderror">
                            <label for="tutor">Precio</label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="{{ $course->price }}" step=".01">
                            @error('tutor')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" col-3">
                            <label for="level">Nivel Académico</label>
                            <select class="form-control" id="course" name="course" data-live-search="true">
                                <option value="">Selecciona un nivel</option>
                                <option value="1" @if ($course->course == 1) selected @endif>1º Primaria
                                </option>
                                <option value="2" @if ($course->course == 2) selected @endif>2º Primaria
                                </option>
                                <option value="3" @if ($course->course == 3) selected @endif>3º Primaria
                                </option>
                                <option value="4" @if ($course->course == 4) selected @endif>4º Primaria
                                </option>
                                <option value="5" @if ($course->course == 5) selected @endif>5º Primaria
                                </option>
                                <option value="6" @if ($course->course == 6) selected @endif>6º Primaria
                                </option>
                                <option value="7" @if ($course->course == 7) selected @endif>1º ESO</option>
                                <option value="8" @if ($course->course == 8) selected @endif>2º ESO</option>
                                <option value="9" @if ($course->course == 9) selected @endif>3º ESO</option>
                                <option value="10" @if ($course->course == 10) selected @endif>4º ESO</option>
                                <option value="11" @if ($course->course == 11) selected @endif>1º Bachillerato
                                </option>
                                <option value="12" @if ($course->course == 12) selected @endif>2º Bachillerato
                                </option>
                                <option value="13" @if ($course->course == 13) selected @endif>Universidad
                                </option>
                                <option value="14" @if ($course->course == 14) selected @endif>Acceso a grados
                                </option>
                                <option value="15" @if ($course->course == 15) selected @endif>Intensivo
                                    Selectividad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row ml-2">
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#add-classes').click(function() {
                var class_id = $('#course').val();
                if (class_id == '') {
                    alert('Selecciona un curso');
                    return;
                } else {
                    $('#sortable').append(
                        '<div class="col-3"><input type="hidden" name="courses[]" value="' + class_id +
                        '"><button type="button" class="btn btn-danger remove-class">Eliminar</button>' +
                        $('#course option:selected').text() +
                        '<input type="" name="courses_price'
                        '</div>');
                }
            });
            $(document).on('click', '.remove-class', function() {
                $(this).parent().remove();
            });
        });
    </script>
@endpush
