@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-white">
                        <span class="font-weight-bold">Editar</span>
                        {{ $role->name }}</div>
                    <div class="card-body">
                        @include('partials._alert')
                        <form action="{{ route('roles.update', $role) }}" method="POST">
                            @method('PUT')

                            @include('role._fields')

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
