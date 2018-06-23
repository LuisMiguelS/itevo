@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Editar {{ $course->name }}</div>
                    <div class="card-body">

                        <form action="{{ route('tenant.courses.update', ['institute' => $institute, 'courses' => $course]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del curso</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $course->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="institute_id" class="col-sm-4 col-form-label text-md-right">Tipo de cursos</label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control {{ $errors->has('type_course_id') ? ' is-invalid' : '' }}" id="type_course_id" name="type_course_id">
                                            <option disabled>Seleciona una opcion</option>
                                            @foreach($typeCourses as $typeCourse)

                                                <option value="{{ $typeCourse->id }}"
                                                    {{ old('type_course_id') == $typeCourse->id ? 'selected' : '' }}>
                                                    {{ $typeCourse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type_course_id'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('type_course_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
