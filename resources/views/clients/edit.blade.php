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
                        @error('tutor') has-error @enderror">
                            <label for="tutor">Apellidos</label>
                            <input type="text" class="form-control" id="tutor" name="surnames"
                                value="{{ $client->surnames }}">
                            @error('tutor')
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
                        @error('school') has-error @enderror">
                            <label for="school">Colegio</label>
                            <input type="text" class="form-control" id="school" name="school"
                                value="{{ $client->school }}">
                            @error('school')
                                <span class="help-block
                                text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="observations">Observaciones</label>
                            <textarea name="observations" id="observations" cols="30" rows="10">{{ $client->observations }}</textarea>
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
                            <label for="course">Asignaturas</label>
                            <select class="form-control" id="course" data-live-search="true">
                                <option value="">Selecciona Asignaturas</option>
                                @foreach ($courses as $course)
                                    @endphp
                                    <option value="{{ $course->id }}" extra-attr="{{ $course->course }}">
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
                            @if (
                                $courseClient->course->course == '1' ||
                                    $courseClient->course->course == '2' ||
                                    $courseClient->course->course == '3' ||
                                    $courseClient->course->course == '4' ||
                                    $courseClient->course->course == '5' ||
                                    $courseClient->course->course == '6' ||
                                    $courseClient->course->course == '7' ||
                                    $courseClient->course->course == '8' ||
                                    $courseClient->course->course == '9' ||
                                    $courseClient->course->course == '10' ||
                                    $courseClient->course->course == '11' ||
                                    $courseClient->course->course == '12')
                                <div class="col-7 mb-2 item-row">
                                    <input type="hidden" name="courses_clients[]" value="{{ $courseClient->id }}">
                                    <input type="hidden" name="courses[]" value="{{ $courseClient->course_id }}">
                                    <button type="button" class="btn btn-danger remove-class">Eliminar</button>
                                    <b>{{ $courseClient->course->name }}</b> Horas:
                                    <select class="form-control w-25 d-inline" id="hours" name="hours[]">
                                        <option value="2" @if ($courseClient->hours == '2') selected @endif>2
                                        </option>
                                        <option value="3" @if ($courseClient->hours == '3') selected @endif>3
                                        </option>
                                        <option value="4" @if ($courseClient->hours == '4') selected @endif>4
                                        </option>
                                        <option value="5" @if ($courseClient->hours == '5') selected @endif>5
                                        </option>
                                        <option value="6" @if ($courseClient->hours == '6') selected @endif>6
                                        </option>
                                        <option value="8" @if ($courseClient->hours == '8') selected @endif>8
                                        </option>
                                    </select>
                                </div>
                            @endif
                            @if ($courseClient->course->course == '13')
                                <div class="col-7 mb-2 item-row"><input type="hidden" name="courses[]"
                                        value="{{ $courseClient->id }}"><button type="button"
                                        class="btn btn-danger remove-class">Eliminar</button>
                                    <b>{{ $courseClient->course->name }}</b> Horas:
                                    <select class="form-control w-25 d-inline" id="hours" name="hours[]">
                                        <option value="1" @if ($courseClient->hours == '1') selected @endif>1
                                        </option>
                                        <option value="2" @if ($courseClient->hours == '2') selected @endif>2
                                        </option>
                                        <option value="3" @if ($courseClient->hours == '3') selected @endif>3
                                        </option>
                                        <option value="4" @if ($courseClient->hours == '4') selected @endif>4
                                        </option>
                                    </select>
                                </div>
                            @endif
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
                    if ($('#course').attr('extra-attr') == '') {
                        alert('Selecciona un curso');
                        return;
                    }
                    if ($('#course option:selected').attr('extra-attr') == '1' || $(
                            '#course option:selected').attr('extra-attr') ==
                        '2' || $('#course option:selected').attr('extra-attr') == '3' || $(
                            '#course option:selected')
                        .attr('extra-attr') == '4' || $('#course option:selected').attr('extra-attr') ==
                        '5' || $(
                            '#course option:selected').attr('extra-attr') == '6' || $(
                            '#course option:selected')
                        .attr('extra-attr') == '7' || $('#course option:selected').attr('extra-attr') ==
                        '8' || $(
                            '#course option:selected').attr('extra-attr') == '9' || $(
                            '#course option:selected') ==
                        '10' || $('#course option:selected').attr('extra-attr') == '11' || $(
                            '#course option:selected')
                        .attr('extra-attr') == '12'
                    ) {
                        $('#sortable').append(
                            '<div class="col-7 mb-2 item-row"><input type="hidden" name="courses[]" value="' +
                            class_id +
                            '"><button type="button" class="btn btn-danger remove-class">Eliminar</button><b>' +
                            $('#course option:selected').text() +
                            '</b>' +
                            ' Horas: ' +
                            '<select class="form-control w-25 d-inline" id="hours" name="hours[]">' +
                            '<option value="2">2</option>' +
                            '<option value="3">3</option>' +
                            '<option value="4">4</option>' +
                            '<option value="5">5</option>' +
                            '<option value="6">6</option>' +
                            '<option value="8">8</option>' +
                            '</select>'
                        );
                    }
                    if ($('#course option:selected').attr('extra-attr') == '13') {
                        $('#sortable').append(
                            '<div class="col-7 mb-2 item-row">' +
                            '<input type="hidden" name="courses[]" value="' + class_id + '">' +
                            '<button type="button" class="btn btn-danger remove-class">Eliminar</button>' +
                            '<b>' +
                            $('#course option:selected').text() +
                            '</b>' +
                            ' Horas: ' +
                            '<select class="form-control w-25 d-inline" id="hours" name="hours[]">' +
                            '<option value="1">1</option>' +
                            '<option value="2">2</option>' +
                            '<option value="3">3</option>' +
                            '<option value="4">4</option>' +
                            '</select>' +
                            '</div>'
                        );
                    }
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
