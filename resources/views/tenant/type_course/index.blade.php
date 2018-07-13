@extends('layouts.tenant')

@section('title', 'Todos los tipos de cursos')

@section('breadcrumb')
    {{ Breadcrumbs::render('typeCourse', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.typeCourses.create', $branchOffice) }}">Crear Tipo de Curso</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($typeCourses->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th><b>Tipo de curso</b></th>
                            <th><b>Acciones</b></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($typeCourses  as $typeCourse)
                                <tr>
                                    <td>{{ $typeCourse->name }}</td>
                                    <td>
                                        @can('tenant-update', $typeCourse)
                                            <a class="btn btn-info btn-xs" href="{{ $typeCourse->url->edit }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('tenant-delete', $typeCourse)
                                            <a class="btn btn-danger btn-xs" href="{{ $typeCourse->url->delete }}"
                                               onclick="event.preventDefault();
                                                   document.getElementById('typeCourse-delete-{{$typeCourse->id}}').submit();">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="typeCourse-delete-{{$typeCourse->id}}" action="{{ $typeCourse->url->delete }}" method="POST" style="display: none;">
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
                        <div class="alert alert-info" role="alert">
                            No hay Tipos de cursos registrados
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
