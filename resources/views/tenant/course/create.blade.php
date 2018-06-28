@extends('layouts.admin')

@section('title', 'Crear Curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        Llena los campos requeridos: <span class="text-danger"><strong>*</strong></span>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ route('tenant.courses.store', $institute) }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del curso: <span class="text-danger"><strong>*</strong></span></label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                  <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="institute_id" class="col-sm-4 col-form-label text-md-right">Tipo de curso: <span class="text-danger"><strong>*</strong></span></label>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control {{ $errors->has('type_course_id') ? ' is-invalid' : '' }}" id="type_course_id" name="type_course_id">
                                        <option>Seleciona una opción...</option>
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
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection