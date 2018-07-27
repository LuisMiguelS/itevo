@extends('layouts.tenant')

@section('title', 'Crear promocion')

@section('breadcrumb')
    {{ Breadcrumbs::render('promotion-create', $branchOffice) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @panel
            <form action="{{ route('tenant.promotions.store', $branchOffice) }}" method="POST">

                @include('tenant.promotion._fields')

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
            @endpanel

        </div>
    </div>
@endsection