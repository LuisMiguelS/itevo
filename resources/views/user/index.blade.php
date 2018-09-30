@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Listado de usuarios</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @box
                @slot('title')
                    Todos los usuarios
                    <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">Crear Usuario</a>
                @endslot

                @slot('body_class', 'no-padding')

                    <table class="table table-striped">
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
                        @forelse($users  as $user)
                            <tr>
                                <th>{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles->pluck('title') as $role)
                                        <span class="label label-primary">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('update', $user)
                                        <a class="btn btn-info btn-xs" href="{{ route('users.edit', $user) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan

                                    @can('delete', $user)
                                        <a class="btn btn-danger btn-xs" href="{{ route('users.destroy', $user) }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('users-delete-{{$user->id}}').submit();">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="users-delete-{{$user->id}}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <th colspan="5"> No hay usuarios registrados</th>
                        @endforelse
                        </tbody>
                    </table>

                {{ $users->links() }}
                @endbox
            </div>
        </div>
    </section>
@endsection
