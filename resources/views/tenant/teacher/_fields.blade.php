@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="control-label">Nombre(s) <span class="text-danger">*</span></label>

    <input id="name"
           name="name"
           type="text"
           class="form-control"
           value="{{ old('name', $teacher->name) }}"
           required
           autofocus>

    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label class="control-label">Apellido(s) <span class="text-danger">*</span></label>

    <input id="last_name"
           name="last_name"
           type="text"
           class="form-control"
           value="{{ old('last_name', $teacher->last_name) }}"
           required>

    @if ($errors->has('last_name'))
        <span class="help-block">
            <strong>{{ $errors->first('last_name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('id_card') ? 'has-error' : '' }}">
    <label class="control-label">Cédula <span class="text-danger">*</span></label>

    <input id="id_card"
           name="id_card"
           type="text"
           class="form-control"
           value="{{ old('id_card', $teacher->id_card) }}"
           data-inputmask='"mask": "999-9999999-9"' data-mask
           required>

    @if ($errors->has('id_card'))
        <span class="help-block">
            <strong>{{ $errors->first('id_card') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label class="control-label">Teléfono <span class="text-danger">*</span></label>

    <input id="phone"
           type="text"
           class="form-control"
           name="phone"
           value="{{ old('phone', $teacher->phone) }}"
           data-inputmask='"mask": "(999) 999-9999"' data-mask
           required>

    @if ($errors->has('phone'))
        <span class="help-block">
            <strong>{{ $errors->first('phone') }}</strong>
        </span>
    @endif
</div>