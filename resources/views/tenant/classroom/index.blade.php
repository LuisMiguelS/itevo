@extends('layouts.tenant')

@section('title', 'Todas las aulas')

@section('breadcrumb')
    {{ Breadcrumbs::render('classroom', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.classrooms.create', $branchOffice) }}">Crear Aula</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($classrooms->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th><strong>Aula</strong></th>
                            <th><strong>Edificio</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($classrooms  as $classroom)
                                <tr>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->building }}</td>
                                    <td>
                                        @can('tenant-update', $classroom)
                                            <a class="btn btn-info btn-xs" href="{{  $classroom->url->edit }}"><i class="fa fa-pencil-alt"></i></a>
                                        @endcan

                                        @can('tenant-delete', $classroom)
                                                <a class="btn btn-danger btn-xs" href="{{ $classroom->url->delete }}"
                                                   onclick="event.preventDefault();
                                                       document.getElementById('classrooms-delete-{{$classroom->id}}').submit();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="classrooms-delete-{{$classroom->id}}" action="{{ $classroom->url->delete }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $classrooms->links() }}
                    @else
                        <div class="alert alert-info" role="alert">
                            No hay aulas registradas
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
