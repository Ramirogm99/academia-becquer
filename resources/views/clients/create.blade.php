@extends('layouts.app')
@section('subtitle', 'Clients')
@section('content_header_title', 'Clientes')
@section('content_header_subtitle', 'Creación de clientes')
{{-- Content body: main page content --}}


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100% ; height : 100%;">
                <form action="{{ route('clients.store') }}" method="POST">
                    <div class="row">
                        @csrf
                        <div class="form-group col-3
                        @error('name') has-error @enderror">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('phone') has-error @enderror">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('tutor') has-error @enderror">
                            <label for="tutor">Tutor</label>
                            <input type="text" class="form-control" id="tutor" name="tutor"
                                value="{{ old('tutor') }}">
                            @error('tutor')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('school') has-error @enderror">
                            <label for="school">Colegio</label>
                            <input type="text" class="form-control" id="school" name="school"
                                value="{{ old('school') }}">
                            @error('school')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" col-3">
                            <label for="level">Nivel Académico</label>
                            <select class="form-control" id="level" name="level" data-live-search="true">
                                <option value="">Selecciona un nivel</option>
                                <option value="1">1º Primaria</option>
                                <option value="2">2º Primaria</option>
                                <option value="3">3º Primaria</option>
                                <option value="4">4º Primaria</option>
                                <option value="5">5º Primaria</option>
                                <option value="6">6º Primaria</option>
                                <option value="7">1º ESO</option>
                                <option value="8">2º ESO</option>
                                <option value="9">3º ESO</option>
                                <option value="10">4º ESO</option>
                                <option value="11">1º Bachillerato</option>
                                <option value="12">2º Bachillerato</option>
                                <option value="13">Universidad</option>
                                <option value="14">Acceso a grados</option>
                                <option value="15">Intensivo Selectividad</option>
                            </select>
                        </div>
                        <div class=" col-3">
                            <label for="course">Cursos</label>
                            <select class="form-control" id="course" data-live-search="true">
                                <option value="">Selecciona el Curso</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" extra-attr="{{ $course->price }}">
                                        {{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 mt-4 p-2">
                            <button type="button" class="btn btn-secondary" id="add-classes">Añadir clase</button>
                        </div>
                    </div>
                    <div id="sortable" class="row mb-5 mt-5">
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
                        '<div class="col-12 mb-2 item-row"><input type="hidden" name="courses[]" value="' +
                        class_id +
                        '"><button type="button" class="btn btn-danger remove-class">Eliminar</button><b>' +
                        $('#course option:selected').text() +
                        '</b><span class="col-2">' + $(
                            '#course option:selected').attr('extra-attr') +
                        '€/h</span><input type="hidden" class="price" value="' +
                        $(
                            '#course option:selected').attr('extra-attr') +
                        '"><input type="number" class="col-2 ml-2 hours" name="hours[]"><span class="price_total"></span><input type="hidden" class="price_calculated" name="price_total[]" value=""></div>'
                    );
                }
            });
        });
        $(document).on('click', '.remove-class', function() {
            $(this).parent().remove();
        });
        $(document).on('change , keyup', '.hours', function() {
            var hours = $(this).val();
            var price = $(this).closest('.item-row').find('.price').val();
            console.log(hours, price);
            var total = hours * price;
            $(this).closest('.item-row').find('.price_calculated').val(total);
            $(this).parent().find('.price_total').text('Total: ' + total + '€');
        });
    </script>
@endpush
