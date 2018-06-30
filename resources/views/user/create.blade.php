@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 font-weight-bold">Crear usuario</div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            @if(auth()->user()->isAn(\App\User::ROLE_ADMIN) || auth()->user()->isAn(\App\User::ROLE_TENANT_ADMIN))
                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Rol</label>
                                <div class="col-md-6">
                                    <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" name="role">
                                        <option>Seleciona un rol para el usuario</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Instituto</label>
                                <div class="col-md-6">
                                    @if($institutes->count())
                                        @foreach($institutes as $institute)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input name="institutes[{{ $institute->id }}]"
                                                       class="custom-control-input {{ $errors->has('institutes') ? ' is-invalid' : '' }}"
                                                       type="checkbox"
                                                       id="institutes{{ $institute->id }}"
                                                       value="{{ $institute->id }}"
                                                    {{ old("institutes.{$institute->id}") ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="institutes{{ $institute->id }}">{{ $institute->name }}</label>
                                            </div>
                                        @endforeach
                                        @if ($errors->has('institutes'))
                                                <br>
                                                <small style="color: #dc3545; font-size: 12px !important;">
                                                    <strong>{{ $errors->first('institutes') }}</strong>
                                                </small>
                                        @endif
                                        @else
                                        <div class="alert alert-primary" role="alert">
                                            No hay institutos registrados
                                        </div>
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
