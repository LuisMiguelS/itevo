@extends('layouts.tenant')

@section('title', 'Configuraciones')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">

            @box

            @slot('title', "Configuraciones {$branchOffice->name}")

            <form action="{{ route('tenant.settings.store', $branchOffice) }}" method="POST">

                @csrf

                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label  class="control-label">Teléfono <span class="text-danger">*</span></label>

                    <input id="phone"
                           name="phone"
                           type="text"
                           class="form-control"
                           value="{{ old('phone', optional($branchOffice->settings)['phone']) }}"
                           data-inputmask='"mask": "(999) 999-9999"' data-mask
                           required>

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label class="control-label">Dirección <span class="text-danger">*</span></label>

                    <textarea id="address"
                              type="text"
                              class="form-control"
                              name="address"
                              required>{{ old('address', optional($branchOffice->settings)['address']) }}</textarea>

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>

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
