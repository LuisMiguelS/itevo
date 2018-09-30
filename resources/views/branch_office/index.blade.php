@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1 style="text-align: center">Lista de sucursal</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @box
                @slot('title')
                    Todas las sucursal
                    <a class="btn btn-primary" href="{{ route('branchOffices.create') }}">Crear sucursal</a>
                @endslot

                @slot('body_class', 'no-padding')

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($branchOffices  as $branchOffice)
                        <tr>
                            <th>{{ $branchOffice->id }}</th>
                            <td>{{ $branchOffice->name }}</td>
                            <td>
                                @can('update', $branchOffice)
                                    <a class="btn btn-info btn-xs" href="{{ $branchOffice->url->edit }}"><i class="fa fa-pencil"></i></a>
                                @endcan

                                @can('delete', $branchOffice)
                                    <a class="btn btn-danger btn-xs" href="{{ $branchOffice->url->delete }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('sucursal-delete-{{$branchOffice->id}}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="sucursal-delete-{{$branchOffice->id}}" action="{{ $branchOffice->url->delete }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <th colspan="3">   No hay sucursales registrados</th>
                    @endforelse
                    </tbody>
                </table>

                {{ $branchOffices->links() }}
                @endbox
            </div>
        </div>
    </section>
@endsection
