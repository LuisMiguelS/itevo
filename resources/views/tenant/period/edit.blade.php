@extends('layouts.tenant')

@section('title', "Editar periodo {$period->period} de la promocion no. { $promotion->promotion_no }")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box
            @slot('title')
                Editar periodo: <strong>{{ $period->period }}</strong> de la promocion No. {{ $promotion->promotion_no }}
            @endslot

            <form action="{{ route('tenant.promotions.periods.update', ['branchOffice' => request('branchOffice'),'promotion' => request('promotion'),'period' => $period]) }}"
                  method="POST">
                @method('PUT')

                @include('tenant.period._fields')

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
