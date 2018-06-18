@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos las Aulas
                        <a href="{{ route('classrooms.create') }}">Crear Aula</a>
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
                                            @can('update', $classroom)
                                                <a href="{{ route('classrooms.edit', $classroom) }}">Editar</a>
                                            @endcan

                                            @can('delete', $classroom)
                                                {{-- <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-xs" type="submit">Borrar</button>
                                                </form> --}}
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            No hay aulas registradas
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
