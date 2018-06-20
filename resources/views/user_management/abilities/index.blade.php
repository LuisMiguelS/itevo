@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todas las habilidades
                        <a href="{{ route('abilities.create') }}">Crear Habilidad</a>
                    </div>
                    <div class="card-body">
                        @if($abilities->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Habilidad</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($abilities  as $abilitie)
                                    <tr>
                                        <th>{{ $abilitie->id }}</th>
                                        <td>{{ $abilitie->title }}</td>
                                        <td>
                                            @can('update', $abilitie)
                                                <a href="{{ route('abilities.edit', $abilitie) }}">Editar</a>
                                            @endcan

                                            @can('delete', $abilitie)
                                                <a href="#">Borrar</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $abilities->links() }}
                        @else
                            No hay Habilidades registradas
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
