@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Listado de habilidades</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @box
                @slot('title', ' Todas las habilidades')

                @slot('body_class', 'no-padding')

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Habilidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($abilities  as $abilitie)
                        <tr>
                            <th>{{ $abilitie->id }}</th>
                            <td>{{ $abilitie->title }}</td>
                        </tr>
                    @empty
                        <th colspan="2"> No hay habilidades registradas</th>
                    @endforelse
                    </tbody>
                </table>

                {{ $abilities->links() }}
                @endbox
            </div>
        </div>
    </section>
@endsection
