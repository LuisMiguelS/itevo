@extends('layouts.tenant')

@section('title', 'Crear aula')

@section('breadcrumb')
    {{ Breadcrumbs::render('classroom-create', $institute) }}
@endsection

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
                    <form action="{{ route('tenant.classrooms.store', $institute) }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del aula: <span class="text-danger"><strong>*</strong></span></label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                  <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del edificio: <span class="text-danger"><strong>*</strong></span></label>

                            <div class="col-md-12">
                                <input id="building" type="text" class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}" name="building" value="{{ old('building') }}">

                                @if ($errors->has('building'))
                                  <span class="invalid-feedback">
                                    <strong>{{ $errors->first('building') }}</strong>
                                </span>
                                @endif
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
