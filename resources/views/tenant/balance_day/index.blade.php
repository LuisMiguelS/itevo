@extends('layouts.tenant')

@section('title', 'Cuadre del día')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @box
                @slot('title', 'Informacion a filtar')
                <form action="{{ route('tenant.balance_day.index', $branchOffice) }}" method="get">
                    <select class="form-control" name="cuadre">
                        <option value="general" @if("general" === request('cuadre')) selected @endif>Cuadre general</option>
                        <option value="cursos" @if("cursos" === request('cuadre')) selected @endif>Cuadre de cursos</option>
                        @foreach($resources as $resource)
                            <option value="{{ strtolower($resource->name) }}" @if(strtolower($resource->name) === request('cuadre')) selected @endif>
                                {{ "Cuadre de ".strtolower($resource->name) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary btn-block" style="margin-top: 1rem">Buscar</button>
                </form>
            @endbox
        </div>
        <div class="col-md-8">
            @box
                @slot('title', 'Información del cuadre')

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Numero de factura</th>
                        <th>Cuadre</th>
                        <th>Sub total</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($balanceDay as $object)
                        <tr>
                            <td>No. {{ $object['factura'] }}</td>
                            <td>{{ $object['cuadre'] }}</td>
                            <td>RD$ {{ number_format($object['precio'], 2, '.', ',') }}</td>
                            <td>{{ $object['fecha'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align: center">No hay datos en esta tabla</td></tr>
                    @endforelse
                    @if(count($balanceDay))
                        <tr>
                            <td colspan="4" style="text-align: right">
                               <h3>
                                   <strong>Total: </strong>
                                   RD$ {{ number_format(collect($balanceDay)->sum('precio'), 2, '.', ',') }}
                               </h3>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            @endbox
        </div>
    </div>
@endsection