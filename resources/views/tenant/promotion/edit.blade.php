@extends('layouts.tenant')

@section('title', 'Editar promocion '. $promotion->promotion_no)

@section('breadcrumb')
    {{ Breadcrumbs::render('promotion-edit', $branchOffice, $promotion) }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        Editar promocion: <strong>{{ $promotion->promotion_no }}</strong>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ $promotion->url->update }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="promotion_no" class="col-sm-4 col-form-label text-md-right">Numero de promocion: <span class="text-danger"><strong>*</strong></span></label>

                            <div class="col-md-12">
                                <input id="promotion_no" type="number" class="form-control{{ $errors->has('promotion_no') ? ' is-invalid' : '' }}" name="promotion_no" value="{{ old('promotion_no', $promotion->promotion_no) }}" required autofocus>

                                @if ($errors->has('promotion_no'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('promotion_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
