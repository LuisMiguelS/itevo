@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 font-weight-bold bg-white">
                        Todos los usuarios
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">Crear Usuario</a>
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
                                            @foreach ($user->roles->pluck('title') as $role)
                                                <span class="badge badge-primary">{{ $role }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('update', $user)
                                                <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            @can('delete', $user)
                                                    <a class="btn btn-danger btn-sm" href="{{ route('users.destroy', $user) }}"
                                                       onclick="event.preventDefault();
                                                           document.getElementById('users-delete-{{$user->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <form id="users-delete-{{$user->id}}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                        @else
                            No hay usuarios registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
