@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Listado de roles</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @box
                @slot('title')
                    Todos los roles
                    <a class="btn btn-primary" href="{{ route('roles.create') }}">Crear Rol</a>
                @endslot

                @slot('body_class', 'no-padding')

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Rol</th>
                        <th>Habilidades</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles  as $role)
                        <tr>
                            <th>{{ $role->id }}</th>
                            <td>{{ $role->title }}</td>
                            <td>
                                @foreach ($role->abilities()->pluck('title') as $ability)
                                    <span class="label label-primary">{{ $ability }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('update', $role)
                                    <a class="btn btn-info btn-xs" href="{{ route('roles.edit', $role) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endcan

                                @can('delete', $role)
                                    <a class="btn btn-danger btn-xs" href="{{ route('roles.destroy', $role) }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('roles-delete-{{$role->id}}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="roles-delete-{{$role->id}}" action="{{ route('roles.destroy', $role) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <th colspan="4">No hay Roles registrados</th>
                    @endforelse
                    </tbody>
                </table>

                {{ $roles->links() }}
                @endbox
            </div>
        </div>
    </section>
@endsection
