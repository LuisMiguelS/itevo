@extends('layouts.tenant')

@section('title', 'Todos los Tipos de Cursos')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.resources.create', $institute) }}">Crear Tipo de Curso</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($typeCourses->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th><strong>#</strong></th>
                            <th><strong>Tipo de curso</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($typeCourses  as $typeCourse)
                                <tr>
                                    <th>{{ $typeCourse->id }}</th>
                                    <td>{{ $typeCourse->name }}</td>
                                    <td>
                                        @can('tenant-update', $typeCourse)
                                            <a class="btn btn-info btn-xs" href="{{ route('tenant.typecourses.edit', ['institute' => $institute, 'typeCourse' => $typeCourse]) }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('tenant-delete', $typeCourse)
                                            <a class="btn btn-danger btn-xs" href="{{ route('tenant.typecourses.destroy', ['institute' => $institute, 'typeCourse' => $typeCourse]) }}"
                                               onclick="event.preventDefault();
                                                   document.getElementById('typeCourse-delete-{{$typeCourse->id}}').submit();">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="typeCourse-delete-{{$typeCourse->id}}" action="{{ route('tenant.typecourses.destroy',  ['institute' => $institute, 'typeCourse' => $typeCourse]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
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
@endsection
