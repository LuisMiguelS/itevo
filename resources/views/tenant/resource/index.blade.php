@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los Recursos
                        <a href="{{ route('tenant.resources.create', $institute) }}">Crear Recurso</a>
                    </div>
                    <div class="card-body">
                        @if($resources->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Recurso</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($resources  as $resource)
                                    <tr>
                                        <th>{{ $resource->id }}</th>
                                        <td>{{ $resource->name }}</td>
                                        <td>
                                            @can('update', $resource)
                                                <a href="{{ route('tenant.resources.edit', ['institute' => $institute, 'resource' => $resource]) }}">Editar</a>
                                            @endcan

                                            @can('delete', $resource)
                                                    <a href="{{ route('tenant.resources.destroy', ['institute' => $institute, 'resource' => $resource]) }}"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('resource-delete-{{$resource->id}}').submit();">
                                                        Eliminar
                                                    </a>
                                                    <form id="resource-delete-{{$resource->id}}" action="{{ route('tenant.resources.destroy',  ['institute' => $institute, 'resource' => $resource]) }}" method="POST" style="display: none;">
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
                            No hay recursos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
