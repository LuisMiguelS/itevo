@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="control-label">Nombre del aula <span class="text-danger">*</span></label>

    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $classroom->name) }}"
           required
           autofocus>

    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('building') ? 'has-error' : '' }}">
    <label class="control-label">Nombre del edificio <span class="text-danger">*</span></label>

    <input type="text"
           name="building"
           class="form-control"
           value="{{ old('building', $classroom->building) }}"
           required>

    @if ($errors->has('building'))
        <span class="help-block">
            <strong>{{ $errors->first('building') }}</strong>
        </span>
    @endif
</div>