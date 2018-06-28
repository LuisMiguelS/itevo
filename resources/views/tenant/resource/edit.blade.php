@extends('layouts.admin')

@section('title', 'Editar Recurso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        Editar Recurso: <strong>{{ $resource->name }}</strong>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ route('tenant.resources.update', ['institute' => $institute, 'resource' => $resource]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del recurso</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $resource->name) }}" required autofocus>

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