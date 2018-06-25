@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los Cursos
                        <a href="{{ route('tenant.courses.create', $institute) }}">Crear Curso</a>
                    </div>
                    <div class="card-body">
                        @if($courses->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Curso</th>
                                <th>Tipo de curso</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($courses  as $course)
                                    <tr>
                                        <th>{{ $course->id }}</th>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->typecourse->name }}</td>
                                        <td>
                                            @can('tenant-update', $course)
                                                <a href="{{ route('tenant.courses.edit', ['institute' => $institute, 'courses' => $course]) }}">
                                                    Editar
                                                </a>
                                            @endcan

                                            @can('tenant-delete', $course)
                                                    <a href="{{ route('tenant.courses.destroy', ['institute' => $institute, 'courses' => $course]) }}"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('courses-delete-{{$course->id}}').submit();">
                                                        Eliminar
                                                    </a>
                                                    <form id="courses-delete-{{$course->id}}" action="{{ route('tenant.courses.destroy',  ['institute' => $institute, 'courses' => $course]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
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
