@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                @box
                @slot('title', "Editar de {$branchOffice->name}")

                <form class="form-horizontal" action="{{ $branchOffice->url->update }}" method="PUT">
                    @method('PUT')
                    @include('branch_office._fields')

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </form>
                @endbox
            </div>
        </div>
    </section>
@endsection
