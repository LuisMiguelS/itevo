@extends('layouts.tenant')

@section('title', 'Editar promocion '. $promotion->promotion_no)

@section('breadcrumb')
    {{ Breadcrumbs::render('promotion-edit', $branchOffice, $promotion) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @panel
                @slot('title')
                    Editar promocion: <strong>{{ $promotion->promotion_no }}</strong>
                @endslot

            <form action="{{ $promotion->url->update }}" method="POST">
                @method('PUT')

                @include('tenant.promotion._fields')

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
