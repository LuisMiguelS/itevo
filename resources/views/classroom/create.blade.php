@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear aula</div>
                    <div class="card-body">
                        <form action="{{ route('classrooms.store') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="institute_id" class="col-sm-4 col-form-label text-md-right">Instituto</label>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control {{ $errors->has('institute_id') ? ' is-invalid' : '' }}" id="institute_id" name="institute_id">
                                            <option disabled>Seleciona una opcion</option>
                                            @foreach($institutes as $institute)

                                                <option value="{{ $institute->id }}"
                                                    {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                                                    {{ $institute->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('institute_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('institute_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del aula</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                      <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del edificio</label>

                                <div class="col-md-6">
                                    <input id="building" type="text" class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}" name="building" value="{{ old('building') }}">

                                    @if ($errors->has('building'))
                                      <span class="invalid-feedback">
                                        <strong>{{ $errors->first('building') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                      Crear
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
