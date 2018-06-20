@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los roles
                        <a href="{{ route('roles.create') }}">Crear Rol</a>
                    </div>
                    <div class="card-body">
                        @if($roles->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rol</th>
                                    <th>Habilidades</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles  as $role)
                                    <tr>
                                        <th>{{ $role->id }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->abilities()->pluck('title') as $ability)
                                                <span class="badge badge-info">{{ $ability }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('update', $role)
                                                <a href="{{ route('roles.edit', $role) }}">Editar</a>
                                            @endcan

                                            @can('delete', $role)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $roles->links() }}
                        @else
                            No hay Roles registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
