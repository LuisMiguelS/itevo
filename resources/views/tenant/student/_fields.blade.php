@csrf

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="control-label">Nombre(s) <span class="text-danger">*</span></label>

    <input id="name"
           type="text"
           class="form-control"
           name="name"
           value="{{ old('name', $student->name) }}"
           required
           autofocus>

    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group  {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label class="control-label">Apellido(s) <span class="text-danger">*</span></label>

    <input id="last_name"
           name="last_name"
           type="text"
           class="form-control"
           value="{{ old('last_name', $student->last_name) }}"
           required>

    @if ($errors->has('last_name'))
        <span class="help-block">
            <strong>{{ $errors->first('last_name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('id_card') ? 'has-error' : '' }}">
    <label class="control-label">Cédula</label>

    <input id="id_card"
           type="text"
           class="form-control"
           name="id_card"
           value="{{ old('id_card', $student->id_card) }}"
           data-inputmask='"mask": "999-9999999-9"' data-mask>

    @if ($errors->has('id_card'))
        <span class="help-block">
            <strong>{{ $errors->first('id_card') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label  class="control-label">Teléfono <span class="text-danger">*</span></label>

    <input id="phone"
           name="phone"
           type="text"
           class="form-control"
           value="{{ old('phone', $student->phone) }}"
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
              required>{{ old('address', $student->address) }}</textarea>

    @if ($errors->has('address'))
        <span class="help-block">
            <strong>{{ $errors->first('address') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}" >
    <label  class="control-label">Fecha de nacimiento <span class="text-danger">*</span></label>

    <input id="birthdate"
           type="date"
           class="form-control"
           name="birthdate"
           value="{{ old('birthdate', $student->birthdate->format('Y-m-d')) }}">

    @if ($errors->has('birthdate'))
        <span class="help-block">
            <strong>{{ $errors->first('birthdate') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('tutor_id_card') ? 'has-error' : '' }}">
    <label class="control-label">Cédula del tutor <small>(Solo si el estudiante no es mayor de edad)</small></label>

    <input id="tutor_id_card"
           type="text"
           class="form-control"
           name="tutor_id_card"
           value="{{ old('tutor_id_card', $student->tutor_id_card) }}"
           data-inputmask='"mask": "999-9999999-9"' data-mask>

    @if ($errors->has('tutor_id_card'))
        <span class="help-block">
            <strong>{{ $errors->first('tutor_id_card') }}</strong>
        </span>
    @endif
</div>