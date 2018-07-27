@extends('layouts.app')

 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item list-group-item font-weight-bold text-center text-uppercase">Sucursales</li>
                @if($branchOffices->count())
                        @foreach($branchOffices as $branchOffice)
                        <a href="{{ route('tenant.dashboard', $branchOffice) }}" class="list-group-item list-group-item-action">
                            <b>{{ $branchOffice->name }}</b>
                        </a>
                        @endforeach
                @else
                    <div class="alert alert-info mt-5" role="alert">
                        No tienes una sucursal asignada...
                    </div>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
