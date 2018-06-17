@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los institutos
                        <a href="{{ route('institutes.create') }}">Crear instituto</a>
                    </div>
                    <div class="card-body">
                        @if($institutes->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($institutes  as $institute)
                                    <tr>
                                        <th>{{ $institute->id }}</th>
                                        <td>{{ $institute->name }}</td>
                                        <td>
                                            @can('update', $institute)
                                                <a href="{{ route('institutes.edit', $institute) }}">Editar</a>
                                            @endcan

                                            @can('delete', $institute)
                                                <a href="#">Eliminar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            No hay instittuos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
