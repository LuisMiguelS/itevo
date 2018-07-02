@extends('layouts.tenant')

@section('title', 'Todos los cursos')

@section('breadcrumb')
    {{ Breadcrumbs::render('course', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.courses.create', $branchOffice) }}">Crear Curso</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($courses->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th><strong>#</strong></th>
                            <th><strong>Curso</strong></th>
                            <th><strong>Tipo de curso</strong></th>
                            <th><strong>Acciones</strong></th>
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
                                            <a class="btn btn-info btn-xs" href="{{ $course->url->edit }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('tenant-delete', $course)
                                                <a class="btn btn-danger btn-xs" href="{{ $course->url->delete }}"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('courses-delete-{{$course->id}}').submit();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="courses-delete-{{$course->id}}" action="{{ $course->url->delete }}" method="POST" style="display: none;">
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
@endsection
