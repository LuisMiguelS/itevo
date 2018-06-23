@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los Tipos de cursos
                        <a href="{{ route('tenant.typecourses.create', $institute) }}">Crear Tipo de curso</a>
                    </div>
                    <div class="card-body">
                        @if($typeCourses->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de curso</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($typeCourses  as $typeCourse)
                                    <tr>
                                        <th>{{ $typeCourse->id }}</th>
                                        <td>{{ $typeCourse->name }}</td>
                                        <td>
                                            @can('update', $typeCourse)
                                                <a href="{{ route('tenant.typecourses.edit', ['institute' => $institute, 'typeCourse' => $typeCourse]) }}">Editar</a>
                                            @endcan

                                            @can('delete', $typeCourse)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $typeCourses->links() }}
                        @else
                            No hay Tipos de cursos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
