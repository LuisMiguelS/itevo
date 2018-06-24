@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        Todas las habilidades
                    </div>
                    <div class="card-body">
                        @if($abilities->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Habilidad</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($abilities  as $abilitie)
                                    <tr>
                                        <th>{{ $abilitie->id }}</th>
                                        <td>{{ $abilitie->title }}</td>
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
