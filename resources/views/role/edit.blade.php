@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0">
                        <span class="font-weight-bold">Editar</span>
                        {{ $role->name }}</div>
                    <div class="card-body">

                        <form action="{{ route('roles.update', $role) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $role->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="abilities" class="col-sm-4 col-form-label text-md-right">Habiliades</label>
                                <div class="col-md-6">
                                    @foreach($abilities as $abilitie)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input name="abilities[{{ $abilitie->id }}]"
                                                   class="custom-control-input"
                                                   type="checkbox"
                                                   id="role_{{ $abilitie->id }}"
                                                   value="{{ $abilitie->id }}"
                                                {{ old("abilities.{$abilitie->id}") || in_array($abilitie->id, $role->getAbilities()->pluck('id', 'id')->toArray()) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="role_{{ $abilitie->id }}">{{ $abilitie->title }}</label>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('abilities[]'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('abilities[]') }}</strong>
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
