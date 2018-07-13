@extends('layouts.tenant')

@section('title', 'Todos los recursos')

@section('breadcrumb')
    {{ Breadcrumbs::render('resource', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a class="btn btn-primary btn-sm" style="color: #fff;" href="{{ route('tenant.resources.create', $branchOffice) }}">Crear Recurso</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($resources->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th><strong>Recurso</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($resources  as $resource)
                                <tr>
                                    <td>{{ $resource->name }}</td>
                                    <td>
                                        @can('tenant-update', $resource)
                                            <a class="btn btn-info btn-xs" href="{{ $resource->url->edit }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('tenant-delete', $resource)
                                            <a class="btn btn-danger btn-xs" href="{{ $resource->url->delete }}"
                                               onclick="event.preventDefault();
                                                   document.getElementById('resource-delete-{{$resource->id}}').submit();">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="resource-delete-{{$resource->id}}" action="{{ $resource->url->delete }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $resources->links() }}
                    @else
                        <div class="alert alert-info" role="alert">
                            No hay recursos registrados
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
