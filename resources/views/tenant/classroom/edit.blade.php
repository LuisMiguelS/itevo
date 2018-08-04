@extends('layouts.tenant')

@section('title', 'Editar aula '. $classroom->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('classroom-edit', $branchOffice, $classroom) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-offset-2">

            @box
                @slot('title')
                    Editar Aula: <strong>{{ $classroom->name }}</strong>
                @endslot

                <form action="{{ $classroom->url->update }}" method="POST">
                    @method('PUT')

                    @include('tenant.classroom._fields')

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </form>
            @endbox
        </div>
    </div>
@endsection
