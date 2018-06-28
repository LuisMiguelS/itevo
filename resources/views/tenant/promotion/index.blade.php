@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-header">
                    Todas las Promociones
                </div>
                <div class="panel-body">
                    @if($promotions->count())
                        <table class="table">
                            <thead>
                            <tr>
                                <th><strong>#</strong></th>
                                <th><strong>Periodo</strong></th>
                                <th><strong>Estado</strong></th>
                                <th><strong>Fecha de Creación</strong></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($promotions  as $promotion)
                                <tr>
                                    <th>{{ "No. {$promotion->id}" }}</th>
                                    <th>{{ "{$promotion->period}-{$promotion->created_at->format('Y')}" }}</th>
                                    <th>{{ $promotion->status }}</th>
                                    <th>{{ $promotion->created_at->format('Y-m-d') }}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $promotions->links() }}
                    @else
                        No hay promociones registradas
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
