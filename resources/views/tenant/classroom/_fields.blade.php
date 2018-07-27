@csrf

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del aula: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $classroom->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label text-md-right">Nombre del edificio: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="name" type="text" class="form-control{{ $errors->has('building') ? ' is-invalid' : '' }}" name="building" value="{{ old('building', $classroom->building) }}">

        @if ($errors->has('building'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('building') }}</strong>
            </span>
        @endif
    </div>
</div>