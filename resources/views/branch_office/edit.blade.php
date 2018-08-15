@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-header border-0 bg-white">
                        <span class="font-weight-bold">Editar</span>
                        {{ $branchOffice->name }}</div>
                    <div class="card-body">
                        @include('partials._alert')

                        <form action="{{ $branchOffice->url->update }}" method="POST">
                            @method('PUT')

                            @include('branch_office._fields')

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
