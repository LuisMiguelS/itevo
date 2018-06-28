@extends('layouts.admin')

@section('title', 'Editar Tipo de Curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        Editar Tipo de Curso: <strong>{{ $typeCourse->name }}</strong>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ route('tenant.typecourses.update', ['institute' => $institute, 'typeCourse' => $typeCourse]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del Tipo de curso: <span class="text-danger"><strong>*</strong></span></label>
                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $typeCourse->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection