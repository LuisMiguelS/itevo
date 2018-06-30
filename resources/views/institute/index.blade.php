@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-header border-0 font-weight-bold">
                        Todos los institutos
                        <a class="btn btn-primary btn-sm" href="{{ route('institutes.create') }}">Crear instituto</a>
                    </div>
                    <div class="card-body">
                        @if($institutes->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($institutes  as $institute)
                                    <tr>
                                        <th>{{ $institute->id }}</th>
                                        <td>{{ $institute->name }}</td>
                                        <td>
                                            @can('update', $institute)
                                                <a class="btn btn-info btn-sm" href="{{ route('institutes.edit', $institute) }}"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan

                                            @can('delete', $institute)
                                                <a class="btn btn-danger btn-sm" href="{{ route('institutes.destroy', $institute) }}"
                                                   onclick="event.preventDefault();
                                                 document.getElementById('institutes-delete-{{$institute->id}}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="institutes-delete-{{$institute->id}}" action="{{ route('institutes.destroy', $institute) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $institutes->links() }}
                        @else
                            No hay instittuos registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
