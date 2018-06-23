@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Editar {{ $user->name }}</div>
                    <div class="card-body">

                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Correo Electrónico</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="abilities" class="col-sm-4 col-form-label text-md-right">Institutos</label>
                                <div class="col-md-6">
                                    @foreach($institutes as $institute)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input name="institutes[{{ $institute->id }}]"
                                                   class="custom-control-input {{ $errors->has('institutes') ? ' is-invalid' : '' }}"
                                                   type="checkbox"
                                                   id="institutes{{ $institute->id }}"
                                                   value="{{ $institute->id }}"
                                                {{ old("institutes.{$institute->id}") || in_array($institute->id, $user->institutes()->get()->pluck('pivot')->pluck('institute_id', 'institute_id')->toArray()) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="institutes{{ $institute->id }}">{{ $institute->name }}</label>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('institutes[]'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('institutes[]') }}</strong>
                                        </span>
                                    @endif
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
