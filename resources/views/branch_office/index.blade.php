@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-header border-0 font-weight-bold bg-white">
                        Todos las sucursal
                        <a class="btn btn-primary btn-sm" href="{{ route('branchOffices.create') }}">Crear sucursal</a>
                    </div>
                    <div class="card-body">
                        @include('partials._alert')

                        @if($branchOffices->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($branchOffices  as $branchOffice)
                                    <tr>
                                        <th>{{ $branchOffice->id }}</th>
                                        <td>{{ $branchOffice->name }}</td>
                                        <td>
                                            @can('update', $branchOffice)
                                                <a class="btn btn-info btn-sm" href="{{ $branchOffice->url->edit }}"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan

                                            @can('delete', $branchOffice)
                                                <a class="btn btn-danger btn-sm" href="{{ $branchOffice->url->delete }}"
                                                   onclick="event.preventDefault();
                                                 document.getElementById('sucursal-delete-{{$branchOffice->id}}').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="sucursal-delete-{{$branchOffice->id}}" action="{{ $branchOffice->url->delete }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $branchOffices->links() }}
                        @else
                            No hay sucursales registrados
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
