@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Edición usuario</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                @box
                @slot('title', "Editar:  {$user->name}")

                <form class="form-horizontal" action="{{ route('users.update', $user) }}" method="PUT">
                    @method('PUT')
                    @include('user._fields')

                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Actualizar
                        </button>
                    </div>
                </form>
                @endbox
            </div>
        </div>
    </section>
@endsection
