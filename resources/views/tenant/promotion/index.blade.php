@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todas las promociones
                    </div>
                    <div class="card-body">
                        @if($promotions->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Periodo</th>
                                    <th>Estado</th>
                                    <th>Fecha de creacion</th>
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
    </div>
@endsection
