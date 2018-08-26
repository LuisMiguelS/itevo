@extends('layouts.tenant')

@section('title', 'Crear periodo')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            <form action="{{ route('tenant.promotions.periods.store', ['branchOffice' => $branchOffice, 'promotion' => $promotion]) }}" method="POST">

                @include('tenant.period._fields')

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
            @endbox

        </div>
    </div>
@endsection