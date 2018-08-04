@csrf

<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Nombre(s): <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $student->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Apellido(s): <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>

        @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('id_card') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Cédula:</label>

    <div class="col-md-12">
        <input id="id_card" type="text" class="form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" name="id_card" value="{{ old('id_card', $student->id_card) }}" >

        @if ($errors->has('id_card'))
            <span class="help-block">
                <strong>{{ $errors->first('id_card') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Teléfono: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone', $student->phone) }}" required>

        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
    <label class="col-sm-4 col-form-label text-md-right">Dirección: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <textarea id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" required>{{ old('phone', $student->address) }}</textarea>

        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('is_adult') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Es adulto: <span class="text-danger"><strong>*</strong></span></label>

    <div class="col-md-12">
        <label class="radio-inline"><input type="radio" name="is_adult" value="1" {{ old('is_adult', $student->is_adult) === 1 ? 'checked' : '' }}>Sí</label>
        <label class="radio-inline"><input type="radio" name="is_adult" value="0" {{ old('is_adult', $student->is_adult) === 1 ? 'checked' : '' }}>No</label>

        @if ($errors->has('is_adult'))
            <span class="help-block">
                <strong>{{ $errors->first('is_adult') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('tutor_id_card') ? 'has-error' : '' }}">
    <label  class="col-sm-12 col-form-label text-md-right">Cédula del tutor: (Si el estudiante no es adulto)</label>

    <div class="col-md-12">
        <input id="tutor_id_card" type="text" class="form-control{{ $errors->has('tutor_id_card') ? ' is-invalid' : '' }}" name="tutor_id_card" value="{{ old('tutor_id_card', $student->tutor_id_card) }}" >

        @if ($errors->has('tutor_id_card'))
            <span class="help-block">
                <strong>{{ $errors->first('tutor_id_card') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row {{ $errors->has('birthdate') ? 'has-error' : '' }}">
    <label  class="col-sm-4 col-form-label text-md-right">Fecha de nacimiento:</label>

    <div class="col-md-12">
        <input id="birthdate" type="text" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}">

        @if ($errors->has('birthdate'))
            <span class="help-block">
                <strong>{{ $errors->first('birthdate') }}</strong>
            </span>
        @endif
    </div>
</div>