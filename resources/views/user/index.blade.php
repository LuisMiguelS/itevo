@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todos los usuarios
                        <a href="{{ route('users.create') }}">Crear Usuario</a>
                    </div>
                    <div class="card-body">
                        @if($users->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>roles</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users  as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles->pluck('name') as $role)
                                                <span class="badge badge-primary">{{ $role }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('update', $user)
                                                <a href="{{ route('users.edit', $user) }}">Editar</a>
                                            @endcan

                                            @can('delete', $user)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                        @else
                            No hay Tipos de cursos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
