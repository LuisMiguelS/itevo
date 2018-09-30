@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 style="text-align: center">Crear Sucursal</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                @box
                @slot('title', 'Creación de sucursal')

                <form class="form-horizontal" action="{{ route('branchOffices.store') }}" method="POST">
                    @include('branch_office._fields')

                    <div class="row">
                       <div class="col-sm-8 col-sm-offset-4">
                           <button type="submit" class="btn btn-primary">
                               Crear
                           </button>
                       </div>
                    </div>
                </form>
                @endbox
            </div>
        </div>
    </section>
@endsection
