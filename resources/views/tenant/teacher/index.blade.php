@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los Cursos
                        <a href="{{ route('tenant.teachers.create', $institute) }}">Crear Profesor</a>
                    </div>
                    <div class="card-body">
                        @if($teachers->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cedula</th>
                                    <th>Telefono</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers  as $teacher)
                                    <tr>
                                        <th>{{ $teacher->id }}</th>
                                        <td>{{ $teacher->full_name }}</td>
                                        <td>{{ $teacher->id_card }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>
                                            @can('tenant-update', $teacher)
                                                <a href="{{ route('tenant.teachers.edit', ['institute' => $institute, 'teachers' => $teacher]) }}">
                                                    Editar
                                                </a>
                                            @endcan

                                            @can('tenant-delete', $teacher)
                                                <a href="{{ route('tenant.teachers.destroy', ['institute' => $institute, 'teachers' => $teacher]) }}"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('teachers-delete-{{$teacher->id}}').submit();">
                                                    Eliminar
                                                </a>
                                                <form id="teachers-delete-{{$teacher->id}}" action="{{ route('tenant.teachers.destroy',  ['institute' => $institute, 'teachers' => $teacher]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $teachers->links() }}
                        @else
                            No hay profesores registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
