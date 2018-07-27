@extends('layouts.tenant')

@section('title', 'Editar recurso '. $resource->name)

@section('breadcrumb')
    {{ Breadcrumbs::render('resource-edit', $branchOffice, $resource) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @panel
                @slot('title')
                    Editar Recurso: <strong>{{ $resource->name }}</strong>
                @endslot

                <form action="{{ $resource->url->update }}" method="POST">
                    @method('PUT')

                    @include('tenant.resource._fields')

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </form>
            @endpanel


        </div>
    </div>
@endsection
