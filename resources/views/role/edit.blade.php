@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Edición rol</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                @box
                @slot('title', "Editar: {$role->name}")

                <form class="form-horizontal" action="{{ route('roles.update', $role) }}" method="POST">
                    @method('PUT')
                    @include('role._fields')

                    <div class="col-sm-10 col-sm-offset-2">
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
