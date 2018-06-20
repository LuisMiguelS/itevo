@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los Cursos
                        <a href="{{ route('courses.create') }}">Crear Curso</a>
                    </div>
                    <div class="card-body">
                        @if($courses->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($courses  as $course)
                                    <tr>
                                        <th>{{ $course->id }}</th>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->type }}</td>
                                        <td>
                                            @can('update', $course)
                                                <a href="{{ route('courses.edit', $course) }}">Editar</a>
                                            @endcan

                                            @can('delete', $course)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $courses->links() }}
                        @else
                            No hay cursos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
