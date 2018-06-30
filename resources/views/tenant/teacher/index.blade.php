@extends('layouts.tenant')

@section('title', 'Todos los profesor')

@section('breadcrumb')
    {{ Breadcrumbs::render('teacher', $institute) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.teachers.create', $institute) }}">Crear Profesor</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($teachers->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th><strong>#</strong></th>
                                <th><strong>Nombre</strong></th>
                                <th><strong>Cedula</strong></th>
                                <th><strong>Telefono</strong></th>
                                <th><strong>Acciones</strong></th>
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
                                            <a class="btn btn-info btn-xs" href="{{ route('tenant.teachers.edit', ['institute' => $institute, 'teachers' => $teacher]) }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('tenant-delete', $teacher)
                                            <a class="btn btn-danger btn-xs" href="{{ route('tenant.teachers.destroy', ['institute' => $institute, 'teachers' => $teacher]) }}"
                                               onclick="event.preventDefault();
                                                   document.getElementById('teachers-delete-{{$teacher->id}}').submit();">
                                                <i class="fa fa-trash"></i>
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
@endsection
