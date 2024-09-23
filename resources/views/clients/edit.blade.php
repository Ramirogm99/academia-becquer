@extends('layouts.app')
@section('subtitle', 'Clients')
@section('content_header_title', 'Clientes')
@section('content_header_subtitle', 'Edición de clientes')
{{-- Content body: main page content --}}


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body" style="width: 100% ; height : 100%;">
                <form action="{{ route('clients.update') }}" method="POST">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <div class="form-group col-3
                        @error('name') has-error @enderror">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $client->name }}">
                            @error('name')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('phone') has-error @enderror">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $client->phone }}">
                            @error('phone')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('tutor') has-error @enderror">
                            <label for="tutor">Tutor</label>
                            <input type="text" class="form-control" id="tutor" name="tutor"
                                value="{{ $client->tutor }}">
                            @error('tutor')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3
                        @error('school') has-error @enderror">
                            <label for="school">Colegio</label>
                            <input type="text" class="form-control" id="school" name="school"
                                value="{{ $client->school }}">
                            @error('school')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" col-3">
                            <label for="level">Nivel Académico</label>
                            <select class="form-control" id="level" name="level" data-live-search="true">
                                <option value="">Selecciona un nivel</option>
                                <option value="1" @if ($client->level == 1) selected @endif>1º Primaria
                                </option>
                                <option value="2" @if ($client->level == 2) selected @endif>2º Primaria
                                </option>
                                <option value="3" @if ($client->level == 3) selected @endif>3º Primaria
                                </option>
                                <option value="4" @if ($client->level == 4) selected @endif>4º Primaria
                                </option>
                                <option value="5" @if ($client->level == 5) selected @endif>5º Primaria
                                </option>
                                <option value="6" @if ($client->level == 6) selected @endif>6º Primaria
                                </option>
                                <option value="7" @if ($client->level == 7) selected @endif>1º ESO</option>
                                <option value="8" @if ($client->level == 8) selected @endif>2º ESO</option>
                                <option value="9" @if ($client->level == 9) selected @endif>3º ESO</option>
                                <option value="10" @if ($client->level == 10) selected @endif>4º ESO</option>
                                <option value="11" @if ($client->level == 11) selected @endif>1º Bachillerato
                                </option>
                                <option value="12" @if ($client->level == 12) selected @endif>2º Bachillerato
                                </option>
                                <option value="13" @if ($client->level == 13) selected @endif>Universidad
                                </option>
                                <option value="14" @if ($client->level == 14) selected @endif>Acceso a grados
                                </option>
                                <option value="15" @if ($client->level == 15) selected @endif>Intensivo
                                    Selectividad</option>
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
                        @foreach ($coursesClient as $courseClient)
                            <div class="col-12 mb-2 item-row">
                                <input type="hidden" name="courses[]" value="{{ $courseClient->id }}">
                                <button type="button" class="btn btn-danger remove-class">Eliminar</button>
                                <b>
                                    {{ $courseClient->course->name }}
                                </b>
                                <span class="col-2">{{ $courseClient->course->price }}€/h</span>
                                <input type="hidden" class="price" value="{{ $courseClient->price }}"><input
                                    type="number" class="col-2 ml-2 hours" name="hours[]"
                                    value="{{ $courseClient->hours }}">
                                <span class="price_total">Total: {{ $courseClient->total }}€</span><input type="hidden"
                                    class="price_calculated" name="price_total[]" value="{{ $courseClient->total }}">
                            </div>
                        @endforeach
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
