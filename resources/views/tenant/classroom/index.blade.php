@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos las Aulas
                        <a href="{{ route('tenant.classrooms.create', $institute) }}">Crear Aula</a>
                    </div>
                    <div class="card-body">
                        @if($classrooms->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Aula</th>
                                <th>Edificio</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($classrooms  as $classroom)
                                    <tr>
                                        <th>{{ $classroom->id }}</th>
                                        <td>{{ $classroom->name }}</td>
                                        <td>{{ $classroom->building }}</td>
                                        <td>
                                            @can('tenant-update', $classroom)
                                                <a href="{{ route('tenant.classrooms.edit', ['institute' => $institute, 'classroom' => $classroom]) }}">Editar</a>
                                            @endcan

                                            @can('tenant-delete', $classroom)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $classrooms->links() }}
                        @else
                            No hay aulas registradas
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
